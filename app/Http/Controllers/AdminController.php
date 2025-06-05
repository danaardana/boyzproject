<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Section;
use App\Models\SectionContent;
use App\Models\Session;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\View;
use App\Models\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        
        // Share unread messages count and recent messages with all admin views
        View::composer('admin.*', function($view) {
            $unreadMessages = ContactMessage::where('is_read', false)->count();
            $recentMessages = ContactMessage::orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            $view->with([
                'unreadMessages' => $unreadMessages,
                'recentMessages' => $recentMessages
            ]);
        });
    }

    public function dashboard()
    {
        $totalSections = DB::table('sections')->count();
        $totalActiveSections = DB::table('sections')->where('is_active', 1)->count();
        
        // Get recent admin login sessions using our new model
        $recentSessions = Session::getAdminLoginHistory(null, 10);
        $sessionStats = Session::getSessionStats();

        return view('admin.dashboard', compact(
            'totalSections',
            'totalActiveSections',
            'recentSessions',
            'sessionStats'
        ));
    }
    
    public function landingPage(){        
        $sections = Section::where('is_active', true)
        ->orderBy('show_order')
        ->limit(10)
        ->get();
        return view('landing.index', compact('sections'));
    }

    public function landingPageTables(){
        $sections = Section::where('is_active', true)
        ->orderBy('show_order')
        ->get();
        return view('admin.landingpage_tables', compact('sections'));
    }
       
    public function subsectionTables($id = null){
        $sectionName = null;
        if ($id) {
            $section = Section::find($id);
            $sectionName = $section ? $section->name : 'Section Not Found';
        }
    
        $sections = SectionContent::join('sections', 'section_contents.section_id', '=', 'sections.id')
            ->select('section_contents.*', 'sections.name as section_name')
            ->when($id, function ($query) use ($id) {
                return $query->where('section_contents.section_id', $id);
            })
            ->get();
    
        return view('admin.subsection_tables', compact('sections', 'sectionName'));
    }
    
    public function faqPage(){        
        return view('admin.faq');
    }    
        
    public function adminPage(){        
        $totalAdmins = Admin::count();
        $admins = Admin::orderBy('created_at', 'desc')->get();
        
        // Get admin login sessions with enhanced data
        $adminSessions = Session::getAdminLoginHistory(null, 50);
        $sessionStats = Session::getSessionStats();

        return view('admin.admin', compact(
            'admins',
            'totalAdmins',
            'adminSessions',
            'sessionStats'
        ));
    }

    public function chatPage(){        
        $messages = ContactMessage::with(['customer', 'assignedAdmin'])
            ->latest()
            ->get();
            
        $selectedMessage = $messages->first();
        
        // Get conversation if there's a selected message
        $conversation = null;
        if ($selectedMessage && $selectedMessage->customer_id) {
            $conversation = ContactMessage::where('customer_id', $selectedMessage->customer_id)
                ->latest()
                ->get();
                
            // Mark message as read if unread
            if (!$selectedMessage->is_read) {
                $selectedMessage->markAsRead();
            }
        }
        
        return view('admin.chat', compact('messages', 'selectedMessage', 'conversation'));
    }

    public function chatbotPage(){
        return view('admin.predefined-messages');
    }
    
    public function historyPage(){
        // Get comprehensive admin login history
        $adminSessions = Session::getAdminLoginHistory(null, 100);
        $sessionStats = Session::getSessionStats();
        $totalSessions = $adminSessions->count();
        
        // Get current admin's sessions
        $currentAdminSessions = Session::getCurrentAdminSessions();
        
        return view('admin.history', compact(
            'adminSessions',
            'sessionStats',
            'totalSessions',
            'currentAdminSessions'
        ));
    }

    /**
     * Get admin login history for specific admin
     */
    public function adminLoginHistory(Request $request, $adminId = null)
    {
        $admin = null;
        if ($adminId) {
            $admin = Admin::findOrFail($adminId);
        }
        
        $sessions = Session::getAdminLoginHistory($adminId, 100);
        
        return view('admin.admin-login-history', compact('sessions', 'admin'));
    }

    /**
     * Clean old sessions
     */
    public function cleanOldSessions()
    {
        $deletedCount = Session::cleanOldSessions();
        
        return back()->with('success', "Cleaned {$deletedCount} old sessions.");
    }

    public function emailVerification($email = null){      
        $admin = \App\Models\Admin::where('email', $email)->first();
    
        if (!$admin) {
            return abort(404, 'Email tidak ditemukan');
        }
        $sections = Section::where('name', 'testimonials')->get();
        $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
        $totalSectionContents = SectionContent::where('section_id', $sections->first()->id)->count();
        return view('admin.email-verification', compact('SectionContents','totalSectionContents', 'admin'));
    }

    public function emailConfirmation(){
        $sections = Section::where('name', 'testimonials')->get();
        $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
        $totalSectionContents = SectionContent::where('section_id', $sections->first()->id)->count();
        return view('admin.email-confirmation', compact('SectionContents','totalSectionContents'));
    }

    /**
     * Store a new admin
     */
    public function storeAdmin(Request $request)
    {
        // Debug: Log incoming request data
        \Log::info('Admin creation request data:', $request->all());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean',
            'send_welcome_email' => 'boolean',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Passwords do not match',
        ]);

        try {
            // Debug: Log what we're about to create
            $adminData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'is_active' => $request->boolean('is_active', true),
                'verified' => false, // Always false for new admins - they must verify via email
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            \Log::info('Creating admin with data:', $adminData);
            
            // Create the admin
            $admin = Admin::create($adminData);
            
            \Log::info('Admin created successfully with ID: ' . $admin->id);

            $emailSent = false;
            
            // Send welcome email if requested
            if ($request->boolean('send_welcome_email', false)) {
                try {
                    // Generate verification URL for new admin
                    $verificationUrl = route('admin.email-verification', ['email' => $admin->email]);
                    
                    \Log::info('Sending welcome email to: ' . $admin->email);
                    
                    \Illuminate\Support\Facades\Mail::to($admin->email)
                        ->send(new \App\Mail\AdminWelcomeEmail($admin, $request->password, $verificationUrl));
                    $emailSent = true;
                    
                    \Log::info('Welcome email sent successfully');
                } catch (\Exception $e) {
                    \Log::error('Failed to send welcome email: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Admin created successfully',
                'email_sent' => $emailSent,
                'admin' => $admin
            ]);

        } catch (\Exception $e) {
            \Log::error('Error creating admin: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create admin: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify an admin
     */
    public function verifyAdmin(Admin $admin)
    {
        try {
            $admin->update(['verified' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Admin verified successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify admin'
            ], 500);
        }
    }

    /**
     * Activate an admin
     */
    public function activateAdmin(Admin $admin)
    {
        try {
            $admin->update(['is_active' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Admin activated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to activate admin'
            ], 500);
        }
    }

    /**
     * Deactivate an admin
     */
    public function deactivateAdmin(Admin $admin)
    {
        try {
            // Prevent deactivating self
            if ($admin->id === auth('admin')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot deactivate your own account'
                ], 403);
            }

            $admin->update(['is_active' => false]);
            
            return response()->json([
                'success' => true,
                'message' => 'Admin deactivated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate admin'
            ], 500);
        }
    }

    /**
     * Delete an admin
     */
    public function deleteAdmin(Admin $admin)
    {
        try {
            // Prevent deleting self
            if ($admin->id === auth('admin')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account'
                ], 403);
            }

            // Clean up related session data
            Session::where('user_id', $admin->id)->delete();
            
            // Delete the admin
            $admin->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Admin deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete admin'
            ], 500);
        }
    }

    /**
     * Check if an email is already taken
     */
    public function checkEmailAvailability(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $exists = Admin::where('email', $request->email)->exists();

        return response()->json([
            'exists' => $exists,
            'available' => !$exists
        ]);
    }
}