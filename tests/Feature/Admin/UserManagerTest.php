<?php

namespace Tests\Feature\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\AuthenticatedTestCase;

class UserManagerTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected string $routeIndex = 'user.index';
    protected string $routeShow = 'user.show';
    protected string $routeDestroy = 'user.destroy';
    protected string $routeSwitchRole = 'user.switch-role';

    public function test_user_index_method_render_correct_view_and_info_if_does_not_have_records(): void
    {
        DB::statement('SET foreign_key_checks=0');
        User::truncate();
        DB::statement('SET foreign_key_checks=1');

        $this->actingAs($this->admin)->get(route($this->routeIndex))->assertOk()
            ->assertViewIs('admin.users.index')
            ->assertSeeText(__('No users'));
    }

    public function test_user_index_method_render_correct_view_and_info_if_have_records(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->admin)->get(route($this->routeIndex))->assertOk()
            ->assertViewIs('admin.users.index')
            ->assertSeeText($user->name)
            ->assertDontSeeText(__('No users'));
    }

    public function test_user_show_method_render_correct_view(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->admin)->get(route($this->routeShow, $user))->assertOk()
            ->assertViewIs('admin.users.show')
            ->assertViewHas('user', $user);
    }

    public function test_user_switch_role_method_admin_to_user(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin->value]);

        $response = $this->actingAs($this->admin)->get(route($this->routeSwitchRole, $user));

        $response->assertRedirect('user/confirm-password');

        $response = $this->actingAs($this->admin)->post(route('password.confirm'), [
            'password' => 'password',
        ]);

        $this->followRedirects($response)->assertOk()->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'role' => UserRole::Admin->value]);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => UserRole::User->value]);
    }

    public function test_user_switch_role_method_user_to_admin(): void
    {
        $user = User::factory()->create(['role' => UserRole::User->value]);

        $response = $this->actingAs($this->admin)->get(route($this->routeSwitchRole, $user));

        $response->assertRedirect('user/confirm-password');

        $response = $this->actingAs($this->admin)->post(route('password.confirm'), [
            'password' => 'password',
        ]);

        $this->followRedirects($response)->assertOk()->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => UserRole::Admin->value]);
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'role' => UserRole::User->value]);
    }

    public function test_user_destroy_method_deletes_the_record(): void
    {
        $user = User::factory()->create();
        $route = route($this->routeDestroy, $user);

        $response = $this->actingAs($this->admin)->delete($route);

        $response->assertRedirectToRoute($this->routeIndex)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    // Access
    public function test_user_index_path_check_accessed(): void
    {
        $route = route($this->routeIndex);

        $this->get($route)->assertRedirectToRoute('login');
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_user_show_path_check_accessed(): void
    {
        $user = User::factory()->create();
        $route = route($this->routeShow, $user);

        $this->get($route)->assertRedirectToRoute('login');
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertStatus(200);
    }

    public function test_user_switch_role_path_check_accessed(): void
    {
        $user = User::factory()->create();
        $route = route($this->routeSwitchRole, $user);

        $this->get($route)->assertRedirectToRoute('login');
        $this->actingAs($this->user)->get($route)->assertStatus(403);
        $this->actingAs($this->admin)->get($route)->assertRedirect();
    }

    public function test_user_destroy_path_check_accessed(): void
    {
        $user = User::factory()->create();
        $route = route($this->routeDestroy, $user);

        $this->get($route)->assertRedirectToRoute('login');
        $this->actingAs($this->user)->delete($route)->assertStatus(403);
        $this->actingAs($this->admin)->delete($route)->assertStatus(302);
    }

    public function test_is_admin_return_true_for_admin(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::Admin->value,
        ]);

        $this->assertTrue($user->isAdmin());
    }

    public function test_is_admin_return_false_for_user_not_being_admin(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::User->value,
        ]);

        $this->assertFalse($user->isAdmin());
    }
}
