<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminSecurityCode extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $securityCode;

    /**
     * Create a new message instance.
     */
    public function __construct(Admin $admin, string $securityCode)
    {
        $this->admin = $admin;
        $this->securityCode = $securityCode;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('admin.email.security_code')
                    ->subject('Security Code for Password Reset - ' . $this->admin->name)
                    ->with([
                        'adminName' => $this->admin->name,
                        'adminId' => $this->admin->id,
                        'securityCode' => $this->securityCode,
                        'expiresAt' => $this->admin->security_code_expires_at,
                    ]);
    }
} 