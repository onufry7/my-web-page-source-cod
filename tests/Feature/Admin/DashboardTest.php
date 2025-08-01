<?php

namespace Tests\Feature\Admin;

use Tests\AuthenticatedTestCase;

class DashboardTest extends AuthenticatedTestCase
{
    public function test_guest_redirect_to_login_page(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect('/login');
    }

    public function test_user_can_not_authorized(): void
    {
        $this->actingAs($this->user)->get(route('admin.dashboard'))->assertStatus(403);
    }

    public function test_admin_can_access(): void
    {
        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertStatus(200);
    }

    public function test_admin_panel_contain_required_buttons(): void
    {
        $this->actingAs($this->admin)->get(route('admin.dashboard'))
            ->assertSeeText(__('Access tokens'))
            ->assertSeeText(__('Technologies'))
            ->assertSeeText(__('Statistics'))
            ->assertSeeText(__('Publishers'))
            ->assertSeeText(__('Sleeves'))
            ->assertSeeText(__('Prints'))
            ->assertSeeText(__('Users'))
            ->assertSeeText(__('Aphorisms'))
            ->assertSeeText(__('Files'));
    }
}
