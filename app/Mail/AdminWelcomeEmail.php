<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Admin;
use Illuminate\Mail\Mailables\Address;

class AdminWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $password;
    public $loginUrl;
    public $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Admin $admin, string $password = null, string $verificationUrl = null)
    {
        $this->admin = $admin;
        $this->password = $password;
        $this->loginUrl = route('admin.login');
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . config('app.name', 'Boy Projects') . ' - Admin Account Created',
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
            html: 'admin.email.welcome_admin',
            text: 'emails.admin-welcome-text',
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
