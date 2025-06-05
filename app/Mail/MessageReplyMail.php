<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\Admin;

class MessageReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $adminResponse;
    public $originalMessage;
    public $messageStatus;
    public $adminName;

    /**
     * Create a new message instance.
     */
    public function __construct(
        Customer $customer,
        string $adminResponse,
        ContactMessage $originalMessage,
        string $messageStatus,
        string $adminName
    ) {
        $this->customer = $customer;
        $this->adminResponse = $adminResponse;
        $this->originalMessage = $originalMessage;
        $this->messageStatus = $messageStatus;
        $this->adminName = $adminName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: ' . ($this->originalMessage->content_key ?? 'Your Message') . ' - Response from ' . config('app.name', 'Boy Projects'),
            from: config('mail.from.address', 'support@boyprojects.com'),
            replyTo: [config('mail.from.address', 'support@boyprojects.com')]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.email.reply',
            with: [
                'customer' => $this->customer,
                'adminResponse' => $this->adminResponse,
                'originalMessage' => $this->originalMessage,
                'messageStatus' => $this->messageStatus,
                'adminName' => $this->adminName,
            ]
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
