<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class AdminReactivationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $reactivationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->reactivationUrl = $this->generateReactivationUrl($admin);
    }

    /**
     * Generate a secure reactivation URL
     */
    private function generateReactivationUrl(Admin $admin)
    {
        $token = hash('sha256', $admin->id . $admin->email . $admin->created_at . config('app.key'));
        return route('admin.reactivate', ['id' => $admin->id, 'token' => $token]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Deactivation Notification - ' . $this->admin->name,
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            replyTo: [new Address(config('mail.from.address'), config('mail.from.name'))],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'admin.email.reactivate',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
} 