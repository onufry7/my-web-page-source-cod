<?php

namespace Tests\Feature\AccessToken;

use App\Mail\AccessTokenRegisterMail;
use App\Models\AccessToken;
use App\Repositories\AccessTokenRepository;
use Illuminate\Support\Facades\Mail;

class AccessTokenControllerTest extends AccessTokenTestCase
{
    public function test_access_token_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('access-token.index')
            ->assertSeeText(__('No access tokens'));
    }

    public function test_access_token_index_method_render_correct_view_and_info_if_have_records(): void
    {
        $accessToken = AccessToken::factory()->create();
        $route = route($this->routeIndex);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('access-token.index')
            ->assertSeeText($accessToken->token)
            ->assertDontSeeText(__('No access tokens'));
    }

    public function test_access_token_show_method_render_correct_view(): void
    {
        $accessToken = AccessToken::factory()->create();
        $route = route($this->routeShow, $accessToken);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('access-token.show');
    }

    public function test_access_token_create_method_render_correct_view(): void
    {
        $route = route($this->routeCreate);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('access-token.create');
    }

    public function test_access_token_edit_method_render_correct_view(): void
    {
        $accessToken = AccessToken::factory()->create();
        $route = route($this->routeEdit, $accessToken);

        $this->actingAs($this->admin)->get($route)->assertOk()
            ->assertViewIs('access-token.edit');
    }

    public function test_access_token_store_method_creates_a_record(): void
    {
        Mail::fake();
        $newAccessToken = AccessToken::factory()->raw();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->admin)->post($route, $newAccessToken);

        $accessToken = AccessToken::where('url', $newAccessToken['url'])->firstOrFail();

        $response->assertRedirectToRoute($this->routeShow, $accessToken)->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('access_tokens', [
            'url' => $newAccessToken['url'],
            'expires_at' => $newAccessToken['expires_at'],
        ]);
        Mail::assertSent(AccessTokenRegisterMail::class, 1);
    }

    public function test_access_token_update_method_updates_the_record(): void
    {
        $accessToken = AccessToken::factory()->create([
            'url' => 'http://www.kaczmarczyk.pl/',
        ]);
        $updateAccessToken = AccessToken::factory()->make([
            'url' => 'http://www.czerwinski.com.pl/',
        ])->toArray();
        $route = route($this->routeUpdate, $accessToken);

        $response = $this->actingAs($this->admin)->put($route, $updateAccessToken);

        $response->assertRedirectToRoute($this->routeShow, $accessToken)->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('access_tokens', [
            'url' => $updateAccessToken['url'],
        ])->assertDatabaseMissing('access_tokens', [
            'url' => $accessToken->url,
        ]);
    }

    public function test_access_token_destroy_method_deletes_the_record(): void
    {
        $accessToken = AccessToken::factory()->create();
        $route = route($this->routeDestroy, $accessToken);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirectToRoute($this->routeIndex)->assertSessionDoesntHaveErrors();
        $this->assertDatabaseMissing('access_tokens', ['id' => $accessToken->id]);
    }

    public function test_access_token_store_method_dont_create_a_record(): void
    {
        Mail::fake();
        $newAccessToken = AccessToken::factory()->make()->toArray();
        $route = route($this->routeStore);

        $this->mock(AccessTokenRepository::class, function ($mock) {
            $mock->shouldReceive('store')->andReturn(false);
        });

        $response = $this->actingAs($this->admin)->post($route, $newAccessToken);

        $response->assertRedirectToRoute($this->routeCreate)
            ->assertSessionHas('flash.banner', __('Failed to add access token!'))
            ->assertSessionHas('flash.bannerStyle', 'danger');

        $this->assertDatabaseMissing('access_tokens', [
            'url' => $newAccessToken['url'],
            'expires_at' => $newAccessToken['expires_at'],
        ]);

        Mail::assertSent(AccessTokenRegisterMail::class, 0);
    }
}
