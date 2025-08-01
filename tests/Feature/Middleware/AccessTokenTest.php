<?php

namespace Tests\Feature\Middleware;

use App\Models\AccessToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\AuthenticatedTestCase;

class AccessTokenTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    public function test_access_to_the_page_without_a_access_token(): void
    {
        Route::get('/example-route', fn () => true)->middleware('access.token');

        $this->get('/example-route')->assertForbidden()->assertSeeText(__('Invalid or expired token!'));
    }

    public function test_access_to_the_page_with_the_access_token(): void
    {
        Route::get('/example-route', fn () => true)->middleware('access.token');
        $accessToken = AccessToken::factory()->create(['url' => env('APP_URL') . '/example-route', 'is_used' => false]);

        $this->get('/example-route?token=' . $accessToken->token)->assertSessionHasNoErrors()->assertOk();
    }

    public function test_register_create_rout_without_a_access_token(): void
    {
        $this->checkAccessTokenRegistrationRouteMiddleware();

        $this->get(route('register'))->assertForbidden()->assertSeeText(__('Invalid or expired token!'));
    }

    public function test_register_create_rout_with_the_access_token(): void
    {
        $this->checkAccessTokenRegistrationRouteMiddleware();

        $accessToken = AccessToken::factory()->create(['url' => route('register'), 'is_used' => false]);

        $this->get(route('register') . '?token=' . $accessToken->token)->assertSessionHasNoErrors()->assertOk();
    }

    public function test_register_store_rout_without_a_access_token(): void
    {
        $this->checkAccessTokenRegistrationRouteMiddleware();

        $this->post(route('register.store'))->assertForbidden()->assertSeeText(__('Invalid or expired token!'));
    }

    public function test_register_store_rout_with_the_access_token(): void
    {
        $this->checkAccessTokenRegistrationRouteMiddleware();

        $accessToken = AccessToken::factory()->create(['url' => route('register'), 'is_used' => false]);
        $request = [
            'access-token' => $accessToken->token->toString(),
            'name' => 'Jacob Kirkland',
            'nick' => 'Aut repellendus',
            'email' => 'gubi@mailinator.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => 'on',
        ];

        $this->post(route('register.store'), $request)->assertSessionHasNoErrors()->assertRedirectToRoute('dashboard');
        $this->assertDatabaseHas('access_tokens', ['id' => $accessToken->id, 'is_used' => true]);
    }

    private function checkAccessTokenRegistrationRouteMiddleware(): void
    {
        $middlewares = Route::getRoutes()->getByName('register')->gatherMiddleware();

        if (!in_array('access.token', $middlewares)) {
            $this->markTestSkipped('Register routs do not use access token.');
        }
    }
}
