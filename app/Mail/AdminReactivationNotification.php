<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminReactivationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $whatsappLink;

    /**
     * Create a new message instance.
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->whatsappLink = "https://api.whatsapp.com/send/?phone=082216649329&text=reactivate%20account%20" . urlencode($admin->name);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('admin.email.reactivate')
                    ->subject('Account Deactivation Notification - ' . $this->admin->name)
                    ->with([
                        'adminName' => $this->admin->name,
                        'adminId' => $this->admin->id,
                        'whatsappLink' => $this->whatsappLink,
                    ]);
    }
} 