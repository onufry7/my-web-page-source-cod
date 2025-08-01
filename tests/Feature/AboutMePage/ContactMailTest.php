<?php

namespace Tests\Feature\AboutMePage;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMailTest extends TestCase
{
    public function test_sending_contact_form_email(): void
    {
        Mail::fake();

        $data = [
            'email' => 'test@example.com',
            'message' => 'To jest testowa wiadomość.',
        ];

        Mail::to('your@email.com')->send(new ContactMail($data));

        Mail::assertSent(ContactMail::class, function ($mail) use ($data) {
            return $mail->hasTo('your@email.com') &&
                $mail->getEmailFrom() === $data['email'] &&
                $mail->getMessage() === $data['message'];
        });
    }
}
