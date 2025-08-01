<?php

namespace Tests\Feature;

use App\Enums\BoardGameType;
use App\Models\BoardGame;
use App\Models\BoardGameSleeve;
use App\Models\Sleeve;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AuthenticatedTestCase;

class PrintTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    public function test_print_index_path_accessed(): void
    {
        $route = route('print.index');

        $this->get($route)->assertRedirect(route('login'));
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_print_index_path_render_correct_view(): void
    {
        $this->actingAs($this->admin)->get(route('print.index'))->assertOk()
            ->assertViewIs('print.index')
            ->assertSeeText(__('Prints'));
    }

    public function test_print_pdf_return_404_if_id_incorrect(): void
    {
        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'null'));

        $response->assertStatus(404);
    }

    public function test_generate_pdf_with_base_games_when_have_data(): void
    {
        BoardGame::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-gier'));

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'attachment; filename=lista-gier.pdf');
    }

    public function test_generate_pdf_with_base_games_when_dont_have_data(): void
    {
        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-gier'));

        $response->assertStatus(status: 302)
            ->assertSessionHas('flash.banner', __('No data to print.'))
            ->assertSessionHas('flash.bannerStyle', 'warning');
    }

    public function test_generate_pdf_with_all_games_including_expansions_when_have_data(): void
    {
        BoardGame::factory()->create(['type' => BoardGameType::Expansion->value]);

        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-gier-z-dodatkami'));

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'attachment; filename=lista-gier-z-dodatkami.pdf');
    }

    public function test_generate_pdf_with_all_games_including_expansions_when_dont_have_data(): void
    {
        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-gier-z-dodatkami'));

        $response->assertStatus(status: 302)
            ->assertSessionHas('flash.banner', __('No data to print.'))
            ->assertSessionHas('flash.bannerStyle', 'warning');
    }

    public function test_generate_pdf_with_all_games_with_sleeves_when_have_data(): void
    {
        BoardGameSleeve::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-gier-z-koszulkami'));

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'attachment; filename=lista-gier-z-koszulkami.pdf');
    }

    public function test_generate_pdf_with_all_games_with_sleeves_when_dont_have_data(): void
    {
        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-gier-z-koszulkami'));

        $response->assertStatus(status: 302)
            ->assertSessionHas('flash.banner', __('No data to print.'))
            ->assertSessionHas('flash.bannerStyle', 'warning');
    }

    public function test_generate_pdf_with_all_sleeves_when_have_data(): void
    {
        Sleeve::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-koszulek'));

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'attachment; filename=lista-koszulek.pdf');
    }

    public function test_generate_pdf_with_all_sleeves_when_dont_have_data(): void
    {
        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-koszulek'));

        $response->assertStatus(status: 302)
            ->assertSessionHas('flash.banner', __('No data to print.'))
            ->assertSessionHas('flash.bannerStyle', 'warning');
    }

    public function test_generate_pdf_with_all_sleeves_used_in_games_when_have_data(): void
    {
        BoardGameSleeve::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-koszulek-w-grach'));

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'attachment; filename=lista-koszulek-w-grach.pdf');
    }

    public function test_generate_pdf_with_all_sleeves_used_in_games_when_dont_have_data(): void
    {
        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-koszulek-w-grach'));

        $response->assertStatus(status: 302)
            ->assertSessionHas('flash.banner', __('No data to print.'))
            ->assertSessionHas('flash.bannerStyle', 'warning');
    }

    public function test_generate_pdf_with_all_games_on_add_date_when_have_data(): void
    {
        BoardGame::factory()->create();
        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-gier-z-datami-dodania'));

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'attachment; filename=lista-gier-wedlug-daty-dodania.pdf');
    }

    public function test_generate_pdf_with_all_games_on_add_date_when_dont_have_data(): void
    {
        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-gier-z-datami-dodania'));

        $response->assertStatus(status: 302)
            ->assertSessionHas('flash.banner', __('No data to print.'))
            ->assertSessionHas('flash.bannerStyle', 'warning');
    }

    public function test_generate_pdf_with_missing_sleeves_when_have_data(): void
    {
        $seeves = Sleeve::factory()->create(['quantity_available' => 0]);
        BoardGameSleeve::factory()->create([
            'sleeve_id' => $seeves->id,
            'quantity' => 10,
        ]);

        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-brakujacych-koszulek'));

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'attachment; filename=lista-brakujacych-koszulek.pdf');
    }

    public function test_generate_pdf_with_missing_sleeves_when_dont_have_data(): void
    {
        $response = $this->actingAs($this->admin)->get(route('print.board-game-pdf', 'lista-brakujacych-koszulek'));

        $response->assertStatus(status: 302)
            ->assertSessionHas('flash.banner', __('No data to print.'))
            ->assertSessionHas('flash.bannerStyle', 'warning');
    }
}
