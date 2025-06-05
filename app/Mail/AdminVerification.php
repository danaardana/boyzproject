<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

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
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Verification Required - ' . $this->admin->name,
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
            html: 'admin.email.verification',
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

    /**
     * Generate a verification token for the admin
     */
    private function generateVerificationToken(Admin $admin)
    {
        return hash('sha256', $admin->id . $admin->email . $admin->created_at);
    }
} 