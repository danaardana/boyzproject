<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\MessageResponse;
use App\Models\Customer;
use App\Models\PredefinedMessage;
use App\Models\Admin;
use App\Events\ContactMessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function chat(Request $request)
    {
        return view('admin.chat');
    }

    public function submit(Request $request)
    {
        try {
            // Validate the incoming request (e.g. name, email, phone, subject, message) as needed.
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            // (Optional) Compute a "content_key" (for example, using the subject) so that the insert does not fail.
            // (If "content_key" is intended to be the subject, then assign it accordingly.)
            $contentKey = $validated['subject'];

            // Create or find customer
            $customer = Customer::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'phone' => $validated['phone'] ?? null,
                ]
            );

            // Insert a new record into contact_messages (using the computed "content_key").
            $contactMessage = ContactMessage::create([
                'customer_id' => $customer->id,
                'content_key' => $contentKey, // (using the subject as "content_key")
                'content' => $validated['message'],
                'category' => $validated['subject'],
                'status' => ContactMessage::STATUS_NEW,
                'is_read' => false,
                'last_update_time' => now(),
            ]);

            // Log successful creation
            \Log::info('Contact message created successfully', [
                'contact_message_id' => $contactMessage->id,
                'customer_id' => $customer->id,
                'content_key' => $contentKey
            ]);

            // (Optional) broadcast an event (e.g. ContactMessageEvent) if you want real-time updates.
            broadcast(new ContactMessageEvent())->toOthers();

            // Redirect to homepage with success message instead of redirecting back
            return redirect('/')->with('success', 'Your message has been sent.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return redirect('/')->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating contact message', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'inbox'); // inbox, important, trash, sent
        
        if ($filter === 'sent') {
            // Handle sent mail - show message responses
            $responses = MessageResponse::with(['admin', 'contactMessage.customer'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
                
            // Get stats for the dashboard
            $stats = $this->getMessageStats();
            
            // Get all admins for assignment
            $admins = Admin::all();
            
            // Get counts for sidebar
            $inboxCount = ContactMessage::notDeleted()->count();
            $unreadMessagesCount = ContactMessage::notDeleted()->where('is_read', false)->count();
            $importantCount = ContactMessage::important()->notDeleted()->count();
            $trashCount = ContactMessage::trashed()->count();
            $sentCount = MessageResponse::count();
            
            return view('admin.messages.messages-sent', compact('responses', 'stats', 'admins', 'unreadMessagesCount', 'inboxCount', 'importantCount', 'trashCount', 'sentCount', 'filter'));
        }
        
        $query = ContactMessage::with(['customer', 'assignedAdmin']);
        
        switch($filter) {
            case 'important':
                $query->important()->notDeleted();
                break;
            case 'trash':
                $query->trashed();
                break;
            default: // inbox
                $query->notDeleted();
                break;
        }
        
        $messages = $query->orderBy('created_at', 'desc')->paginate(15);
            
        // Get stats for the dashboard
        $stats = $this->getMessageStats();
        
        // Get all admins for assignment
        $admins = Admin::all();
        
        // Get counts for sidebar
        $inboxCount = ContactMessage::notDeleted()->count();
        $unreadMessagesCount = ContactMessage::notDeleted()->where('is_read', false)->count();
        $importantCount = ContactMessage::important()->notDeleted()->count();
        $trashCount = ContactMessage::trashed()->count();
        $sentCount = MessageResponse::count();
        
        return view('admin.messages.messages', compact('messages', 'stats', 'admins', 'unreadMessagesCount', 'inboxCount', 'importantCount', 'trashCount', 'sentCount', 'filter'));
    }

    /**
     * Get message statistics for the dashboard
     */
    private function getMessageStats()
    {
        $stats = [
            'by_status' => [
                ContactMessage::STATUS_NEW => ContactMessage::where('status', ContactMessage::STATUS_NEW)->count(),
                ContactMessage::STATUS_IN_PROGRESS => ContactMessage::where('status', ContactMessage::STATUS_IN_PROGRESS)->count(),
                ContactMessage::STATUS_RESOLVED => ContactMessage::where('status', ContactMessage::STATUS_RESOLVED)->count(),
                ContactMessage::STATUS_CLOSED => ContactMessage::where('status', ContactMessage::STATUS_CLOSED)->count(),
            ],
            'unassigned' => ContactMessage::whereNull('admin_id')->count(),
            'total' => ContactMessage::count(),
        ];

        return $stats;
    }

    public function show(ContactMessage $message)
    {
        // Mark as read if not already read
        if (!$message->is_read) {
            $message->markAsRead();
        }
        
        // Load the responses relationship
        $message->load(['responses.admin']);
        
        return view('admin.messages.messages-single', compact('message'));
    }

    public function showSentMessage(MessageResponse $response)
    {
        // Load the relationships
        $response->load(['admin', 'contactMessage.customer']);
        
        return view('admin.messages.messages-sent-single', compact('response'));
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->markAsRead();
        
        // Broadcast the event
        broadcast(new ContactMessageEvent())->toOthers();
        
        return back()->with('success', 'Message marked as read.');
    }

    public function markAllAsRead()
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);
        
        // Broadcast the event
        broadcast(new ContactMessageEvent())->toOthers();
        
        return back()->with('success', 'All messages marked as read.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        
        // Broadcast the event
        broadcast(new ContactMessageEvent())->toOthers();
        
        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    public function respond(Request $request, ContactMessage $message)
    {
        $request->validate([
            'response' => 'required|string',
            'status' => 'nullable|string'
        ]);

        try {
            // Get the current admin
            $admin = auth('admin')->user();
            $newStatus = $request->status ?? ContactMessage::STATUS_RESOLVED;

            // Create new response record
            $response = $message->responses()->create([
                'admin_id' => $admin->id,
                'message' => $request->response,
            ]);

            // Update message status and assignment
            $message->update([
                'status' => $newStatus,
                'admin_id' => $message->admin_id ?? $admin->id, // Assign to current admin if not already assigned
                'last_update_time' => now()
            ]);

            // Send email to customer
            $emailSent = false;
            if ($message->customer && $message->customer->email) {
                try {
                    \Mail::to($message->customer->email)->send(
                        new \App\Mail\MessageReplyMail(
                            $message->customer,
                            $request->response,
                            $message,
                            $newStatus,
                            $admin->name
                        )
                    );
                    
                    $emailSent = true;
                    \Log::info('Reply email sent successfully', [
                        'customer_email' => $message->customer->email,
                        'message_id' => $message->id,
                        'admin_id' => $admin->id
                    ]);
                } catch (\Exception $emailError) {
                    \Log::error('Failed to send reply email', [
                        'error' => $emailError->getMessage(),
                        'customer_email' => $message->customer->email,
                        'message_id' => $message->id
                    ]);
                    // Don't fail the whole operation if email fails
                }
            } else {
                \Log::warning('Cannot send reply email - customer or email not found', [
                    'message_id' => $message->id,
                    'has_customer' => !!$message->customer,
                    'customer_email' => $message->customer ? $message->customer->email : null
                ]);
            }

            // Broadcast the event
            broadcast(new ContactMessageEvent())->toOthers();

            $successMessage = 'Response sent successfully';
            if ($emailSent) {
                $successMessage .= ' and email notification sent to customer';
            } else {
                $successMessage .= ' (email notification could not be sent)';
            }

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $successMessage
                ]);
            }

            return back()->with('success', $successMessage);

        } catch (\Exception $e) {
            \Log::error('Error in respond method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'message_id' => $message->id
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send response. Please try again.'
                ], 500);
            }

            return back()->withErrors(['response' => 'Failed to send response. Please try again.']);
        }
    }

    public function assign(Request $request, ContactMessage $message)
    {
        // If no admin_id is provided, assign to current admin
        $adminId = $request->input('admin_id', auth('admin')->id());
        
        // Validate the admin exists
        if ($adminId && !Admin::find($adminId)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid admin selected.'
                ], 400);
            }
            return back()->withErrors(['admin_id' => 'Invalid admin selected.']);
        }

        $message->update([
            'admin_id' => $adminId,
            'status' => ContactMessage::STATUS_IN_PROGRESS
        ]);
        
        // Broadcast the event
        broadcast(new ContactMessageEvent())->toOthers();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message assigned successfully.'
            ]);
        }

        return back()->with('success', 'Message assigned successfully.');
    }

    public function toggleImportant(ContactMessage $message)
    {
        $isImportant = $message->toggleImportant();
        
        // Broadcast the event
        broadcast(new ContactMessageEvent())->toOthers();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_important' => $isImportant,
                'message' => $isImportant ? 'Message marked as important.' : 'Message unmarked as important.'
            ]);
        }
        
        return back()->with('success', $isImportant ? 'Message marked as important.' : 'Message unmarked as important.');
    }

    public function moveToTrash(ContactMessage $message)
    {
        // Check if message is already in trash
        if ($message->is_deleted) {
            // If already in trash, permanently delete from database
            $message->delete();
            
            // Broadcast the event
            broadcast(new ContactMessageEvent())->toOthers();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Message permanently deleted from database.'
                ]);
            }
            
            return redirect()->route('admin.messages.index', ['filter' => 'trash'])
                ->with('success', 'Message permanently deleted from database.');
        } else {
            // If not in trash, move to trash (soft delete)
            $message->moveToTrash();
            
            // Broadcast the event
            broadcast(new ContactMessageEvent())->toOthers();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Message moved to trash.'
                ]);
            }
            
            return back()->with('success', 'Message moved to trash.');
        }
    }

    public function restoreFromTrash(ContactMessage $message)
    {
        $message->restoreFromTrash();
        
        // Broadcast the event
        broadcast(new ContactMessageEvent())->toOthers();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message restored from trash.'
            ]);
        }
        
        return back()->with('success', 'Message restored from trash.');
    }

    public function permanentDelete(ContactMessage $message)
    {
        $message->delete();
        
        // Broadcast the event
        broadcast(new ContactMessageEvent())->toOthers();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message permanently deleted.'
            ]);
        }
        
        return redirect()->route('admin.messages.index', ['filter' => 'trash'])
            ->with('success', 'Message permanently deleted.');
    }

    public function getChatSuggestions()
    {
        $suggestions = PredefinedMessage::active()
            ->forChat()
            ->orderBy('category')
            ->orderBy('display_order')
            ->get();
            
        return response()->json($suggestions);
    }

    /**
     * Get auto response for public chat
     */
    public function getAutoResponse(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        try {
            // Use the existing ChatbotController logic
            $chatbotController = new \App\Http\Controllers\Admin\ChatbotController();
            return $chatbotController->getAutoResponse($request);
        } catch (\Exception $e) {
            \Log::error('Error in getAutoResponse', [
                'error' => $e->getMessage(),
                'message' => $request->message
            ]);

            return response()->json([
                'success' => false,
                'matched' => false,
                'message' => 'Error processing request'
            ], 500);
        }
    }

    /**
     * Get intelligent response using ML model for public chat
     */
    public function getIntelligentResponse(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        try {
            // Use the existing ChatbotController logic
            $chatbotController = new \App\Http\Controllers\Admin\ChatbotController();
            return $chatbotController->getIntelligentResponse($request);
        } catch (\Exception $e) {
            \Log::error('Error in getIntelligentResponse', [
                'error' => $e->getMessage(),
                'message' => $request->message
            ]);

            return response()->json([
                'success' => false,
                'type' => 'error',
                'message' => 'Error processing intelligent response'
            ], 500);
        }
    }

    /**
     * API endpoint for real-time message notifications
     */
    public function getMessageNotifications()
    {
        $unreadMessages = ContactMessage::where('is_read', false)->count();
        $recentMessages = ContactMessage::with('customer')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'unread_count' => $unreadMessages,
            'recent_messages' => $recentMessages->map(function($message) {
                return [
                    'id' => $message->id,
                    'customer_name' => $message->customer->name ?? 'Unknown',
                    'customer_email' => $message->customer->email ?? '',
                    'subject' => $message->category,
                    'content' => \Str::limit($message->content, 60),
                    'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                    'time_ago' => $message->created_at->diffForHumans(),
                    'is_read' => $message->is_read
                ];
            })
        ]);
    }
}
