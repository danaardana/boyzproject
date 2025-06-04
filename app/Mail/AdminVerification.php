<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Admin $admin, string $verificationUrl = null)
    {
        $this->admin = $admin;
        $this->verificationUrl = $verificationUrl ?? route('admin.verify', ['id' => $admin->id, 'token' => $this->generateVerificationToken($admin)]);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('admin.email.verification')
                    ->subject('Email Verification Required - ' . $this->admin->name)
                    ->with([
                        'adminName' => $this->admin->name,
                        'adminId' => $this->admin->id,
                        'verificationUrl' => $this->verificationUrl,
                    ]);
    }

    /**
     * Generate a verification token for the admin
     */
    private function generateVerificationToken(Admin $admin)
    {
        return hash('sha256', $admin->id . $admin->email . $admin->created_at);
    }
} 