<?php

namespace App\Mail;

use App\Models\AccessToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccessTokenRegisterMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private AccessToken $accessToken;

    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Token dostepu do rejestracji',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.access-token-register',
            with: ['accessToken' => $this->accessToken]
        );
    }
}
