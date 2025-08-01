<?php

namespace Tests\Feature\Cipher;

use App\Models\Cipher;

class CipherViewsTest extends CipherTestCase
{
    // Buttons
    public function test_cipher_add_button_checking_the_visibility_on_index_page(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Add'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Add'));
    }

    public function test_cipher_edit_button_checking_the_visibility_on_show_page(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeShow, $cipher);

        $this->get($route)->assertDontSeeText(__('Edit'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Edit'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Edit'));
    }

    public function test_cipher_delete_button_checking_the_visibility_on_show_page(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeShow, $cipher);

        $this->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->user)->get($route)->assertDontSeeText(__('Delete'));
        $this->actingAs($this->admin)->get($route)->assertSeeText(__('Delete'));
    }

    public function test_cipher_search_bar_is_visible(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertSeeLivewire('search-bars.cipher-search-bar');
    }
}
