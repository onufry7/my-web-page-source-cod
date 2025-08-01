<?php

namespace Tests\Feature\AboutMePage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_sending_contact_form(): void
    {
        $response = $this->post(route('contact.submit'), [
            'email' => 'test@example.com',
            'message' => 'Test message',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('flash.banner', __('Message was sent.'));
    }

    public function test_requires_email_field(): void
    {
        $response = $this->post(route('contact.submit'), [
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_valid_email_format(): void
    {
        $response = $this->post(route('contact.submit'), [
            'email' => 'invalid_email',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_requires_message_field(): void
    {
        $response = $this->post(route('contact.submit'), [
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('message');
    }

    public function test_message_not_exceed_max_length(): void
    {
        $response = $this->post(route('contact.submit'), [
            'email' => 'test@example.com',
            'message' => str_repeat('a', 5000),
        ]);

        $response->assertSessionHasErrors('message');
    }

    public function test_honey_pot(): void
    {
        $response = $this->post(route('contact.submit'), [
            'email' => 'test@example.com',
            'message' => str_repeat('a', 80),
            'firstname' => 'test',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('flash.banner', __('Failed to send message!'));
    }
}
