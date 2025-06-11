<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminMessageMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $customer;
    public $subject;
    public $messageBody;
    public $adminName;

    /**
     * Create a new message instance.
     */
    public function __construct(Customer $customer, string $subject, string $messageBody, string $adminName)
    {
        $this->customer = $customer;
        $this->subject = $subject;
        $this->messageBody = $messageBody;
        $this->adminName = $adminName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
            from: config('mail.from.address', 'admin@boyzproject.com'),
            replyTo: config('mail.from.address', 'admin@boyzproject.com'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.email.admin_message',
            with: [
                'customer' => $this->customer,
                'subject' => $this->subject,
                'messageBody' => $this->messageBody,
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
