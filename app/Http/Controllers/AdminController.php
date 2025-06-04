<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Section;
use App\Models\SectionContent;
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
        
        $sessions = DB::table('sessions')->orderBy('last_activity', 'desc')->limit(50)->get();
    
        $sessions = $sessions->map(function($session) {
            $agent = new Agent();
            $agent->setUserAgent($session->user_agent);
    
            return (object) [
                'id' => $session->id,
                'platform' => $agent->platform(),
                'browser' => $agent->browser(),
                'device' => $agent->device(),
                'last_activity' => date('d-m-Y, H:i:s', $session->last_activity),
            ];
        });

        return view('admin.dashboard', compact('totalSections','totalActiveSections','sessions'));
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
        
        $sessions = DB::table('sessions')->orderBy('last_activity', 'desc')->limit(50)->get();
    
        $sessions = $sessions->map(function($session) {
            $agent = new Agent();
            $agent->setUserAgent($session->user_agent);
    
            return (object) [
                'id' => $session->id,
                'user_agent' => $session->user_agent,
                'ip_address' => $session->ip_address,
                'user_id' => $session->user_id,
                'platform' => $agent->platform(),
                'browser' => $agent->browser(),
                'device' => $agent->device(),
                'is_mobile' => $agent->isMobile(),
                'is_desktop' => $agent->isDesktop(),
                'last_activity' => date('d-m-Y H:i:s', $session->last_activity),
            ];
        });

        return view('admin.admin', compact('admins','totalAdmins','sessions'));
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
        $totalSessions = DB::table('sessions')->count();
        $sessions = DB::table('sessions')->orderBy('last_activity', 'desc')->limit(50)->get();
    
        $sessions = $sessions->map(function($session) {
            $agent = new Agent();
            $agent->setUserAgent($session->user_agent);
    
            return (object) [
                'id' => $session->id,
                'user_agent' => $session->user_agent,
                'ip_address' => $session->ip_address,
                'user_id' => $session->user_id,
                'platform' => $agent->platform(),
                'browser' => $agent->browser(),
                'device' => $agent->device(),
                'is_mobile' => $agent->isMobile(),
                'is_desktop' => $agent->isDesktop(),
                'last_activity' => date('d-m-Y H:i:s', $session->last_activity),
            ];
        });
    
        return view('admin.history', compact('sessions','totalSessions'));
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
}