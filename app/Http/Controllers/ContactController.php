<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\MessageResponse;
use App\Models\Customer;
use App\Models\PredefinedMessage;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function chat(Request $request, ContactMessage $message = null)
    {
        // Get all messages for the sidebar
        $messages = ContactMessage::with('customer')
            ->latest()
            ->get();

        // If a specific message is selected, load its details
        $selectedMessage = $message ?? $messages->first();
        
        // Get the conversation history if there's a selected message
        $conversation = null;
        if ($selectedMessage) {
            // Mark the message as read
            if (!$selectedMessage->is_read) {
                $selectedMessage->markAsRead();
            }

            // Get all messages between this customer and admin
            if ($selectedMessage->customer_id) {
                $conversation = ContactMessage::where('customer_id', $selectedMessage->customer_id)
                    ->latest()
                    ->get();
            }
        }

        // Get stats for the dashboard
        $stats = $this->getMessageStats();
        
        // Get all admins for assignment
        $admins = Admin::all();

        return view('admin.messages', compact('messages', 'selectedMessage', 'conversation', 'stats', 'admins'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create or find customer
        $customer = Customer::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
            ]
        );

        // Create contact message
        $message = ContactMessage::create([
            'customer_id' => $customer->id,
            'content' => $validated['message'],
            'category' => $validated['subject'],
            'status' => ContactMessage::STATUS_NEW,
            'is_read' => false,
            'last_update_time' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully!'
        ]);
    }

    public function index()
    {
        $messages = ContactMessage::with(['customer', 'assignedAdmin'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        // Get stats for the dashboard
        $stats = $this->getMessageStats();
        
        // Get all admins for assignment
        $admins = Admin::all();
            
        return view('admin.messages', compact('messages', 'stats', 'admins'));
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
        
        return view('admin.messages-single', compact('message'));
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->markAsRead();
        return back()->with('success', 'Message marked as read.');
    }

    public function markAllAsRead()
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'All messages marked as read.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    public function respond(Request $request, ContactMessage $message)
    {
        $request->validate([
            'response' => 'required|string',
            'status' => 'nullable|string'
        ]);

        // Create new response record
        $message->responses()->create([
            'admin_id' => auth('admin')->id(),
            'message' => $request->response,
        ]);

        // Update message status and assignment
        $message->update([
            'status' => $request->status ?? ContactMessage::STATUS_RESOLVED,
            'admin_id' => $message->admin_id ?? auth('admin')->id(), // Assign to current admin if not already assigned
            'last_update_time' => now()
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Response sent successfully'
            ]);
        }

        return back()->with('success', 'Response sent successfully.');
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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message assigned successfully.'
            ]);
        }

        return back()->with('success', 'Message assigned successfully.');
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
}
