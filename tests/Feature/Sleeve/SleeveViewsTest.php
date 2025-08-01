<?php

namespace Tests\Feature\Sleeve;

use App\Models\Sleeve;

class SleeveViewsTest extends SleeveTestCase
{
    // Buttons
    public function test_sleeve_add_button_checking_the_visibility_on_index_page(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Add'));
    }

    public function test_sleeve_edit_button_checking_the_visibility_on_show_page(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeShow, $sleeve);

        $this->get($route)->assertDontSeeText(__('Edit'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Edit'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Edit'));
    }

    public function test_sleeve_delete_button_checking_the_visibility_on_show_page(): void
    {
        $sleeve = Sleeve::factory()->create();
        $route = route($this->routeShow, $sleeve);

        $this->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Delete'));
    }
}
