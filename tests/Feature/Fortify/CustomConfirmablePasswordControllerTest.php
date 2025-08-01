<?php

namespace Tests\Feature\Fortify;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\AuthenticatedTestCase;

class CustomConfirmablePasswordControllerTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    public function test_show_method_puts_url_before_confirm_in_session_if_not_exists()
    {
        $previousUrl = url('/jakas-strona');
        $this->withHeader('referer', $previousUrl);

        Session::forget('url.before_confirm');

        $response = $this->actingAs($this->admin)->get(route('password.confirm'));

        $response->assertOk();
        $this->assertEquals($previousUrl, session('url.before_confirm'));
    }

    public function test_show_method_does_not_override_existing_url_before_confirm()
    {
        session(['url.before_confirm' => 'https://example.com/zapamietany']);

        $response = $this->actingAs($this->admin)->get(route('password.confirm'));

        $response->assertOk();
        $this->assertEquals('https://example.com/zapamietany', session('url.before_confirm'));
    }

    public function test_store_remove_url_before_confirm_after_correct_confirmation()
    {
        session(['url.before_confirm' => 'https://example.com/powrot']);

        $this->actingAs($this->admin)
            ->post(route('password.confirm'), [
                'password' => 'password',
            ]);

        $this->assertNull(session('url.before_confirm'));
    }

    public function test_store_do_not_remove_url_before_confirm_after_in_correct_confirmation()
    {
        session(['url.before_confirm' => 'https://example.com/powrot']);

        $this->actingAs($this->admin)->post(route('password.confirm'), [
            'password' => 'wrong',
        ]);

        $this->assertEquals('https://example.com/powrot', session('url.before_confirm'));
    }

    public function test_back_method_redirects_to_stored_url_and_removes_it_from_session()
    {
        session(['url.before_confirm' => 'https://example.com/powrot']);

        $response = $this->actingAs($this->admin)->get(route('password.confirm.back'));

        $response->assertRedirect('https://example.com/powrot');
        $this->assertNull(session('url.before_confirm'));
    }

    public function test_back_method_redirects_to_home_if_session_key_missing()
    {
        session()->forget('url.before_confirm');

        $response = $this->actingAs($this->admin)->get(route('password.confirm.back'));

        $response->assertRedirect(route('home'));
    }

    public function test_back_redirects_to_home_when_url_before_confirm_is_null()
    {
        session(['url.before_confirm' => null]);

        $response = $this->actingAs($this->admin)->get(route('password.confirm.back'));

        $response->assertRedirect(route('home'));
    }

    public function test_back_redirects_to_home_when_url_before_confirm_is_empty_string()
    {
        session(['url.before_confirm' => '']);

        $response = $this->actingAs($this->admin)->get(route('password.confirm.back'));

        $response->assertRedirect(route('home'));
    }

    public function test_back_redirects_to_home_when_url_before_confirm_is_array()
    {
        session(['url.before_confirm' => ['foo', 'bar']]);

        $response = $this->actingAs($this->admin)->get(route('password.confirm.back'));

        $response->assertRedirect(route('home'));
    }
}
