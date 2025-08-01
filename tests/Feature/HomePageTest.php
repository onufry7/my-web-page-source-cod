<?php

namespace Tests\Feature;

use Tests\AuthenticatedTestCase;

class HomePageTest extends AuthenticatedTestCase
{
    public function test_home_page_is_available_for_all(): void
    {
        $route = route('home');

        $this->get($route)->assertStatus(200);
        $this->actingAs($this->user)->get($route)->assertStatus(200);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_home_page_contain_required_buttons(): void
    {
        $this->get(route('home'))
            ->assertSeeText(__('About Me'))
            ->assertSeeText(__('Contact'))
            ->assertSeeText(__('Branding'))
            ->assertSeeText(__('Hobby'))
            ->assertSeeText(__('Projects'))
            ->assertSeeText(__('Ciphers'))
            ->assertSeeText(__('Board games'));
    }
}
