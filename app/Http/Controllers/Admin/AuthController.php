<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Models\Section;
use App\Models\SectionContent;
use App\Mail\AdminSecurityCode;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRules;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout', 'lockscreen', 'unlock', 'showChangePasswordForm', 'changePassword']);
        $this->middleware('auth:admin')->only(['logout', 'lockscreen', 'unlock', 'showChangePasswordForm', 'changePassword']);
    }

    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Get testimonials for the background
        $sections = Section::where('name', 'testimonials')->get();
        $SectionContents = [];
        $totalSectionContents = 0;
        
        if ($sections->isNotEmpty()) {
            $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
            $totalSectionContents = $SectionContents->count();
        }

        return view('admin.auth.login', [
            'SectionContents' => $SectionContents,
            'totalSectionContents' => $totalSectionContents
        ]);
    }

    /**
     * Handle admin login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Handle admin logout request
     */
    public function logout(Request $request)
    {
        // Store admin email for logging purposes
        $adminEmail = Auth::guard('admin')->user()->email ?? 'Unknown';
        
        // Logout the admin
        Auth::guard('admin')->logout();

        // Invalidate the session completely
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear all session data
        $request->session()->flush();

        // Add cache control headers to prevent caching
        return redirect()->route('admin.login')
            ->with('status', 'You have been logged out successfully.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Show the lockscreen
     */
    public function lockscreen(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $admin = Auth::guard('admin')->user();
        session(['lockscreen_admin_id' => $admin->id]);

        Auth::guard('admin')->logout();

        // Get testimonials for the lockscreen background
        $sections = Section::where('name', 'testimonials')->get();
        $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
        $totalSectionContents = SectionContent::where('section_id', $sections->first()->id)->count();
        
        return view('admin.lockscreen', compact('admin', 'SectionContents', 'totalSectionContents'));
    }

    /**
     * Handle unlock request
     */
    public function unlock(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $adminId = session('lockscreen_admin_id');
        if (!$adminId) {
            return redirect()->route('admin.login');
        }

        $admin = Admin::find($adminId);
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors([
                'password' => 'Invalid password.',
            ]);
        }

        Auth::guard('admin')->login($admin);
        session()->forget('lockscreen_admin_id');

        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the password reset request form
     */
    public function showForgotForm()
    {
        // Get testimonials for the background
        $sections = Section::where('name', 'testimonials')->get();
        $SectionContents = [];
        $totalSectionContents = 0;
        
        if ($sections->isNotEmpty()) {
            $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
            $totalSectionContents = $SectionContents->count();
        }

        return view('admin.auth.forgot-password', [
            'SectionContents' => $SectionContents,
            'totalSectionContents' => $totalSectionContents
        ]);
    }

    /**
     * Handle the password reset request
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        $securityCode = $admin->generateSecurityCode();

        // Send security code via email using our email system
        try {
            Mail::to($admin->email)->send(new AdminSecurityCode($admin, $securityCode));
            
            return redirect()
                ->route('admin.password.reset')
                ->with([
                    'status' => 'Security code has been sent to your email.',
                    'email' => $request->email
                ]);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send security code. Please try again.']);
        }
    }

    /**
     * Show the password reset form
     */
    public function showResetForm()
    {
        // Get testimonials for the background
        $sections = Section::where('name', 'testimonials')->get();
        $SectionContents = [];
        $totalSectionContents = 0;
        
        if ($sections->isNotEmpty()) {
            $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
            $totalSectionContents = $SectionContents->count();
        }

        return view('admin.auth.reset-password', [
            'token' => '', // Not used in our security code system
            'email' => session('email', ''),
            'SectionContents' => $SectionContents,
            'totalSectionContents' => $totalSectionContents
        ]);
    }

    /**
     * Handle the password reset
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'security_code' => 'required|string',
            'password' => ['required', 'confirmed', PasswordRules::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
            ],
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !$admin->verifySecurityCode($request->security_code)) {
            return back()->withErrors(['security_code' => 'Invalid or expired security code.']);
        }

        // Update password and clear security code
        $admin->password = Hash::make($request->password);
        $admin->clearSecurityCode();

        return redirect()->route('admin.login')
            ->with('status', 'Your password has been reset successfully.');
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        // Get testimonials for the background
        $sections = Section::where('name', 'testimonials')->get();
        $SectionContents = SectionContent::where('section_id', $sections->first()->id)->get();
        $totalSectionContents = SectionContent::where('section_id', $sections->first()->id)->count();
        
        return view('admin.auth.change-password', compact('SectionContents', 'totalSectionContents'));
    }

    /**
     * Handle password change
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', PasswordRules::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
            ],
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.dashboard')
            ->with('status', 'Password changed successfully.');
    }
} 