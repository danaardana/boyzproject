<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ContactMessage;
use App\Models\ChatConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index()
    {
        $customers = Customer::with(['contactMessages', 'chatConversations'])
            ->orderBy('created_at', 'desc')
            ->paginate(12); // 12 customers per page (3 rows of 4 cards)

        // Calculate stats from all customers (not just current page)
        $allCustomers = Customer::with(['contactMessages', 'chatConversations'])->get();
        
        $totalCustomers = $allCustomers->count();
        $activeCustomers = $allCustomers->filter(function ($customer) {
            return $customer->latest_activity && $customer->latest_activity->gt(now()->subDays(30));
        })->count();

        $customersWithMessages = $allCustomers->filter(function ($customer) {
            return $customer->total_messages > 0;
        })->count();

        $customersWithUnread = $allCustomers->filter(function ($customer) {
            return $customer->hasUnreadMessages();
        })->count();

        return view('admin.customers', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'customersWithMessages',
            'customersWithUnread'
        ));
    }

    /**
     * Display the specified customer
     */
    public function show($id)
    {
        \Log::info('CustomerController show method called', ['id' => $id, 'is_ajax' => request()->ajax()]);
        
        try {
            $customer = Customer::with([
                'contactMessages' => function($q) {
                    $q->orderBy('created_at', 'desc');
                },
                'chatConversations' => function($q) {
                    $q->orderBy('created_at', 'desc');
                }
            ])->findOrFail($id);
            
            \Log::info('Customer found', ['customer_id' => $customer->id, 'customer_name' => $customer->name]);
        } catch (\Exception $e) {
            \Log::error('Error finding customer', ['id' => $id, 'error' => $e->getMessage()]);
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found'
                ], 404);
            }
            
            abort(404);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'address' => $customer->address ?? '',
                    'created_at' => $customer->created_at ? $customer->created_at->format('M d, Y H:i') : 'N/A',
                    'updated_at' => $customer->updated_at ? $customer->updated_at->format('M d, Y H:i') : 'N/A',
                    'latest_activity' => $customer->latest_activity ? $customer->latest_activity->format('M d, Y H:i') : 'N/A',
                    'total_messages' => $customer->total_messages,
                    'total_conversations' => $customer->total_conversations,
                    'has_unread_messages' => $customer->hasUnreadMessages(),
                    'contact_messages' => $customer->contactMessages->map(function($msg) {
                        return [
                            'id' => $msg->id,
                            'subject' => $msg->content_key,
                            'status' => $msg->status,
                            'category' => $msg->category,
                            'created_at' => $msg->created_at->format('M d, Y H:i')
                        ];
                    }),
                    'chat_conversations' => $customer->chatConversations->map(function($conv) {
                        return [
                            'id' => $conv->id,
                            'status' => $conv->status,
                            'initial_message' => \Str::limit($conv->initial_message, 100),
                            'created_at' => $conv->created_at->format('M d, Y H:i')
                        ];
                    })
                ]
            ]);
        }

        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Send email to customer
     */
    public function sendEmail(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $customer = Customer::findOrFail($id);
            
            if (!$customer->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer does not have an email address'
                ], 400);
            }

            // Create a contact message record
            $contactMessage = ContactMessage::create([
                'customer_id' => $customer->id,
                'admin_id' => auth('admin')->id(),
                'content_key' => $request->subject,
                'content' => $request->message,
                'category' => 'admin_message',
                'status' => ContactMessage::STATUS_NEW,
                'is_read' => true,
                'last_update_time' => now()
            ]);

            // Send email (you may want to create a specific Mailable for this)
            Mail::to($customer->email)->send(
                new \App\Mail\AdminMessageMail(
                    $customer,
                    $request->subject,
                    $request->message,
                    auth('admin')->user()->name
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully to ' . $customer->name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send email to customer via AJAX
     */
    public function sendEmailAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $customer = Customer::findOrFail($request->customer_id);
            
            if (!$customer->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer does not have an email address'
                ], 400);
            }

            // Create a contact message record
            $contactMessage = ContactMessage::create([
                'customer_id' => $customer->id,
                'admin_id' => auth('admin')->id(),
                'content_key' => $request->subject,
                'content' => $request->message,
                'category' => 'admin_message',
                'status' => ContactMessage::STATUS_NEW,
                'is_read' => true,
                'last_update_time' => now()
            ]);

            // Send email
            Mail::to($customer->email)->send(
                new \App\Mail\AdminMessageMail(
                    $customer,
                    $request->subject,
                    $request->message,
                    auth('admin')->user()->name ?? 'Admin'
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully to ' . $customer->name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete customer
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            
            // Delete related records first
            $customer->contactMessages()->delete();
            $customer->chatConversations()->delete();
            
            // Delete the customer
            $customer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete customer: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search customers
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return response()->json([
                'success' => true,
                'customers' => []
            ]);
        }

        // Since data is encrypted, we need to get all customers and filter
        $allCustomers = Customer::all();
        $filteredCustomers = $allCustomers->filter(function ($customer) use ($query) {
            return str_contains(strtolower($customer->name), strtolower($query)) ||
                   str_contains(strtolower($customer->email), strtolower($query)) ||
                   ($customer->phone && str_contains($customer->phone, $query));
        });

        $customers = $filteredCustomers->take(10)->map(function ($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'latest_activity' => $customer->latest_activity ? $customer->latest_activity->diffForHumans() : 'No activity',
                'total_messages' => $customer->total_messages,
                'has_unread' => $customer->hasUnreadMessages()
            ];
        })->values();

        return response()->json([
            'success' => true,
            'customers' => $customers
        ]);
    }

    /**
     * Get customer statistics
     */
    public function getStats()
    {
        $totalCustomers = Customer::count();
        $customersWithEmail = Customer::whereNotNull('email')->count();
        $customersWithPhone = Customer::whereNotNull('phone')->count();
        
        // Recent customers (last 30 days)
        $recentCustomers = Customer::where('created_at', '>=', now()->subDays(30))->count();
        
        return response()->json([
            'success' => true,
            'stats' => [
                'total_customers' => $totalCustomers,
                'customers_with_email' => $customersWithEmail,
                'customers_with_phone' => $customersWithPhone,
                'recent_customers' => $recentCustomers,
                'email_percentage' => $totalCustomers > 0 ? round(($customersWithEmail / $totalCustomers) * 100, 1) : 0,
                'phone_percentage' => $totalCustomers > 0 ? round(($customersWithPhone / $totalCustomers) * 100, 1) : 0
            ]
        ]);
    }

    /**
     * Update customer information
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $customer = Customer::findOrFail($id);
            
            // Check if email is already taken by another customer
            $existingCustomer = Customer::findByEmail($request->email);
            if ($existingCustomer && $existingCustomer->id !== $customer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email address is already in use by another customer'
                ], 400);
            }

            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Customer information updated successfully',
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update customer: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export customers data
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        $customers = Customer::with(['contactMessages', 'chatConversations'])->get();
        
        $data = $customers->map(function ($customer) {
            return [
                'ID' => $customer->id,
                'Name' => $customer->name,
                'Email' => $customer->email,
                'Phone' => $customer->phone ?? 'N/A',
                'Address' => $customer->address ?? 'N/A',
                'Total Messages' => $customer->total_messages,
                'Total Conversations' => $customer->total_conversations,
                'Latest Activity' => $customer->latest_activity ? $customer->latest_activity->format('Y-m-d H:i:s') : 'N/A',
                'Has Unread Messages' => $customer->hasUnreadMessages() ? 'Yes' : 'No',
                'Created At' => $customer->created_at->format('Y-m-d H:i:s'),
            ];
        });

        if ($format === 'json') {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            // CSV export
            $filename = 'customers_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($data) {
                $file = fopen('php://output', 'w');
                
                // Add headers
                if ($data->isNotEmpty()) {
                    fputcsv($file, array_keys($data->first()));
                }
                
                // Add data
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }
}
