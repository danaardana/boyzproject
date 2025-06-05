<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Mail\AdminReactivationNotification;
use App\Mail\AdminSecurityCode;
use App\Mail\AdminVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    /**
     * Send reactivation notification email
     */
    public function sendReactivationNotification(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id'
        ]);

        $admin = Admin::findOrFail($request->admin_id);

        try {
            Mail::to($admin->email)->send(new AdminReactivationNotification($admin));
            
            return response()->json([
                'success' => true,
                'message' => 'Reactivation notification sent successfully to ' . $admin->email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send security code email
     */
    public function sendSecurityCode(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id'
        ]);

        $admin = Admin::findOrFail($request->admin_id);

        try {
            // Generate security code
            $securityCode = $admin->generateSecurityCode();
            
            Mail::to($admin->email)->send(new AdminSecurityCode($admin, $securityCode));
            
            return response()->json([
                'success' => true,
                'message' => 'Security code sent successfully to ' . $admin->email,
                'expires_at' => $admin->security_code_expires_at
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send security code: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send verification email
     */
    public function sendVerification(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id'
        ]);

        $admin = Admin::findOrFail($request->admin_id);

        try {
            Mail::to($admin->email)->send(new AdminVerification($admin));
            
            return response()->json([
                'success' => true,
                'message' => 'Verification email sent successfully to ' . $admin->email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify admin account
     */
    public function verifyAdmin(Request $request, $id, $token)
    {
        $admin = Admin::findOrFail($id);
        
        // Verify token
        $expectedToken = hash('sha256', $admin->id . $admin->email . $admin->created_at);
        
        if ($token !== $expectedToken) {
            return redirect()->route('admin.login')->with('error', 'Invalid verification token.');
        }

        $admin->markAsVerified();
        
        return redirect()->route('admin.login')->with('success', 'Account verified successfully! You can now login.');
    }

    /**
     * Reactivate admin account
     */
    public function reactivateAdmin(Request $request, $id, $token)
    {
        $admin = Admin::findOrFail($id);
        
        // Verify token (same logic as verification)
        $expectedToken = hash('sha256', $admin->id . $admin->email . $admin->created_at . config('app.key'));
        
        if ($token !== $expectedToken) {
            return redirect()->route('admin.login')->with('error', 'Invalid reactivation token or link has expired.');
        }

        // Check if admin is already active
        if ($admin->is_active) {
            return redirect()->route('admin.login')->with('status', 'Your account is already active. You can login now.');
        }

        // Reactivate the admin account
        $admin->is_active = true;
        $admin->save();

        // Log the reactivation (optional)
        \Log::info("Admin account reactivated: {$admin->email} (ID: {$admin->id})");
        
        return redirect()->route('admin.login')->with('success', 'Your account has been successfully reactivated! You can now login.');
    }

    /**
     * Send bulk emails
     */
    public function sendBulkEmails(Request $request)
    {
        $request->validate([
            'email_type' => 'required|in:reactivation,security_code,verification',
            'admin_ids' => 'required|array',
            'admin_ids.*' => 'exists:admins,id'
        ]);

        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        foreach ($request->admin_ids as $adminId) {
            $admin = Admin::find($adminId);
            
            try {
                switch ($request->email_type) {
                    case 'reactivation':
                        Mail::to($admin->email)->send(new AdminReactivationNotification($admin));
                        break;
                    case 'security_code':
                        $securityCode = $admin->generateSecurityCode();
                        Mail::to($admin->email)->send(new AdminSecurityCode($admin, $securityCode));
                        break;
                    case 'verification':
                        Mail::to($admin->email)->send(new AdminVerification($admin));
                        break;
                }
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
                $errors[] = "Failed to send to {$admin->email}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => $errorCount === 0,
            'message' => "Emails sent successfully: {$successCount}, Failed: {$errorCount}",
            'success_count' => $successCount,
            'error_count' => $errorCount,
            'errors' => $errors
        ]);
    }
} 