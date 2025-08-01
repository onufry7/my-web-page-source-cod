<?php

namespace Tests\Feature;

use App\Models\Gameplay;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class DashboardTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    public function test_dashboard_path_accessed(): void
    {
        $route = route('dashboard');

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_dashboard_path_render_correct_view(): void
    {
        $this->actingAs($this->user)->get(route('dashboard'))->assertOk()
            ->assertViewIs('dashboard')
            ->assertSeeText(__('Welcome') . ' ' . $this->user->nick . '!');
    }

    public function test_dashboard_contain_required_buttons(): void
    {
        $this->actingAs($this->user)->get(route('dashboard'))
            ->assertSeeText(__('Gameplays'))
            ->assertSeeText(__('Shelf of shame'));
    }

    public function test_dashboard_shows_top_10_games_for_authenticated_user_with_correct_count(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $gameplay1 = Gameplay::factory()->create(['user_id' => $user->id, 'count' => 3]);
        $gameplay2 = Gameplay::factory()->create(['user_id' => $user->id, 'count' => 5]);
        $gameplay3 = Gameplay::factory()->create(['user_id' => $user->id, 'count' => 2]);

        Gameplay::factory()->create(['count' => 4]);
        Gameplay::factory()->create(['count' => 6]);

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee($gameplay1->boardGame->name);
        $response->assertSee($gameplay1->total_count);
        $response->assertSee($gameplay2->total_count);
        $response->assertSee($gameplay3->total_count);
    }

    public function test_dashboard_shows_top_10_games_no_more_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Gameplay::factory(12)->create(['user_id' => $user->id]);

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $this->assertCount(10, $response->original->getData()['top10Games']);
    }
}
