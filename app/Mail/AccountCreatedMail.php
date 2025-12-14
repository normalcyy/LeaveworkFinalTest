<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $email;
    public $defaultPassword;
    public $resetLink;
    public $fullName;

    /**
     * Create a new message instance.
     */
    public function __construct($firstName, $email, $defaultPassword, $resetLink, $fullName)
    {
        $this->firstName = $firstName;
        $this->email = $email;
        $this->defaultPassword = $defaultPassword;
        $this->resetLink = $resetLink;
        $this->fullName = $fullName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@yourdomain.com', 'LeaveWork Admin'),
            subject: 'LeaveWork Account Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            text: 'emails.account_created_text',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}