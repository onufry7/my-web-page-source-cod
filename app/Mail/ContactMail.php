<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $message;
    private string $emailFrom;

    public function __construct(array $data)
    {
        $this->message = $data['message'];
        $this->emailFrom = $data['email'];
    }

    public function envelope(): Envelope
    {
        $mailTo = is_string(config('mail.from.contact')) ? config('mail.from.contact') : '';
        $pageMail = is_string(config('mail.from.addres')) ? config('mail.from.addres') : '';

        return new Envelope(
            subject: __('Contact mail from my page.'),
            from: $pageMail,
            to: [$mailTo]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: ['messages' => $this->message, 'from' => $this->emailFrom]
        );
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getEmailFrom(): string
    {
        return $this->emailFrom;
    }
}
