<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Display the chat interface
     */
    public function index()
    {
        $conversations = ChatConversation::with(['customer', 'latestMessage'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.messages.chat', compact('conversations'));
    }

    /**
     * Start a new chat conversation
     */
    public function startConversation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'initial_message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $customerId = null;
            
            // If email is provided, check if customer exists or create new one
            if ($request->customer_email) {
                $customer = Customer::updateOrCreate(
                    ['email' => $request->customer_email],
                    [
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                        'status' => 'active'
                    ]
                );
                $customerId = $customer->id;
            }

            // Create chat conversation
            $conversation = ChatConversation::create([
                'customer_id' => $customerId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'status' => ChatConversation::STATUS_ACTIVE,
                'priority' => ChatConversation::PRIORITY_NORMAL,
                'initial_message' => $request->initial_message,
            ]);

            // Create initial message
            $message = ChatMessage::create([
                'conversation_id' => $conversation->id,
                'sender_type' => ChatMessage::SENDER_CUSTOMER,
                'sender_id' => null, // No sender_id for customers
                'message_content' => $request->initial_message,
                'message_type' => ChatMessage::TYPE_TEXT,
                'is_read' => false,
            ]);

            // Create welcome system message
            ChatMessage::create([
                'conversation_id' => $conversation->id,
                'sender_type' => ChatMessage::SENDER_ADMIN,
                'sender_id' => null,
                'message_content' => 'Welcome to Boy Projects support! Your conversation has been recorded and an admin will assist you shortly.',
                'message_type' => ChatMessage::TYPE_SYSTEM,
                'is_read' => true,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Chat conversation started successfully',
                'conversation_id' => $conversation->id,
                'customer_stored' => !is_null($customerId)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to start conversation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get conversation messages
     */
    public function getConversation($conversationId)
    {
        $conversation = ChatConversation::with(['messages' => function($query) {
            $query->orderBy('created_at', 'asc');
        }])->findOrFail($conversationId);

        // Mark admin messages as read
        $conversation->messages()
            ->where('sender_type', ChatMessage::SENDER_ADMIN)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'conversation' => $conversation,
            'messages' => $conversation->messages
        ]);
    }

    /**
     * Send admin reply
     */
    public function sendReply(Request $request, $conversationId)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $conversation = ChatConversation::findOrFail($conversationId);
            
            $message = ChatMessage::create([
                'conversation_id' => $conversation->id,
                'sender_type' => ChatMessage::SENDER_ADMIN,
                'sender_id' => auth('admin')->id(),
                'message_content' => $request->message,
                'message_type' => ChatMessage::TYPE_TEXT,
                'is_read' => false,
            ]);

            // Update conversation timestamp and assign admin if not assigned
            $conversation->update([
                'admin_id' => auth('admin')->id(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully',
                'chat_message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send reply: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Transfer conversation to another admin
     */
    public function transferConversation(Request $request, $conversationId)
    {
        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|exists:admins,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $conversation = ChatConversation::findOrFail($conversationId);
            $conversation->update(['admin_id' => $request->admin_id]);

            // Add system message about transfer
            ChatMessage::create([
                'conversation_id' => $conversation->id,
                'sender_type' => ChatMessage::SENDER_ADMIN,
                'sender_id' => auth('admin')->id(),
                'message_content' => 'Conversation transferred to another admin.',
                'message_type' => ChatMessage::TYPE_SYSTEM,
                'is_read' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Conversation transferred successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to transfer conversation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Close/resolve conversation
     */
    public function resolveConversation($conversationId)
    {
        try {
            $conversation = ChatConversation::findOrFail($conversationId);
            
            // Update conversation status
            $conversation->update([
                'status' => ChatConversation::STATUS_RESOLVED,
                'resolved_at' => now(),
                'resolved_by' => auth('admin')->id()
            ]);

            // Mark all messages in this conversation as read
            $conversation->markAllAsRead();

            // Add system message about resolution
            ChatMessage::create([
                'conversation_id' => $conversation->id,
                'sender_type' => ChatMessage::SENDER_ADMIN,
                'sender_id' => auth('admin')->id(),
                'message_content' => 'Conversation has been resolved and closed.',
                'message_type' => ChatMessage::TYPE_SYSTEM,
                'is_read' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Conversation resolved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resolve conversation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get chat statistics
     */
    public function getStats()
    {
        $stats = [
            'total_conversations' => ChatConversation::count(),
            'active_conversations' => ChatConversation::where('status', ChatConversation::STATUS_ACTIVE)->count(),
            'resolved_conversations' => ChatConversation::where('status', ChatConversation::STATUS_RESOLVED)->count(),
            'unread_messages' => ChatMessage::where('sender_type', ChatMessage::SENDER_CUSTOMER)
                                           ->where('is_read', false)->count(),
            'customers_with_email' => ChatConversation::whereNotNull('customer_email')->count(),
            'customers_without_email' => ChatConversation::whereNull('customer_email')->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Check if customer exists by phone number
     */
    public function checkCustomerByPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number is required',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $phone = $request->phone;
            $customer = Customer::findByPhone($phone);
            
            if ($customer) {
                // Check if customer has chat history
                $hasChatHistory = $customer->chatConversations()->exists();
                
                return response()->json([
                    'success' => true,
                    'customer_exists' => true,
                    'customer' => [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'email' => $customer->email,
                        'phone' => $customer->phone,
                    ],
                    'has_chat_history' => $hasChatHistory,
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'customer_exists' => false,
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Error checking customer by phone: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to check customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Start conversation from landing page (public)
     */
    public function startConversationFromLanding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'initial_message' => 'required|string|max:1000',
            'existing_customer' => 'boolean',
            'customer_id' => 'nullable|integer|exists:customers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $customerId = null;
            
            // Handle customer creation/update
            if ($request->existing_customer && $request->customer_id) {
                // Use existing customer
                $customerId = $request->customer_id;
                $customer = Customer::findOrFail($customerId);
                
                // Update customer info if needed
                $customer->update([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                ]);
            } else {
                // Create or find customer by phone
                $customer = Customer::findByPhone($request->customer_phone);
                
                if ($customer) {
                    // Update existing customer
                    $customer->update([
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                    ]);
                    $customerId = $customer->id;
                } else {
                    // Create new customer
                    $customer = Customer::create([
                        'name' => $request->customer_name,
                        'phone' => $request->customer_phone,
                        'email' => $request->customer_email,
                    ]);
                    $customerId = $customer->id;
                }
            }

            // Create the conversation
            $conversation = ChatConversation::create([
                'customer_id' => $customerId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'initial_message' => $request->initial_message,
                'status' => 'active',
                'priority' => 'normal',
                'last_message_at' => now(),
            ]);

            // Create the initial message
            $message = ChatMessage::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'customer',
                'message_content' => $request->initial_message,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Conversation started successfully',
                'conversation_id' => $conversation->id,
                'conversation' => $conversation,
                'customer_saved' => true,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating conversation from landing page: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to start conversation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send reply from landing page (public)
     */
    public function sendReplyFromLanding(Request $request, $conversationId)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Find the conversation
            $conversation = ChatConversation::findOrFail($conversationId);
            
            // Create the customer message
            $message = ChatMessage::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'customer',
                'message_content' => $request->message
            ]);
            
            // Update conversation's last message timestamp
            $conversation->update([
                'last_message_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'message_id' => $message->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get conversation messages for polling (public)
     */
    public function getConversationMessages(Request $request, $conversationId)
    {
        try {
            // Find the conversation
            $conversation = ChatConversation::findOrFail($conversationId);
            
            // Get all messages for this conversation
            $messages = ChatMessage::where('conversation_id', $conversation->id)
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'messages' => $messages,
                'conversation' => $conversation
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get messages: ' . $e->getMessage()
            ], 500);
        }
    }
}
