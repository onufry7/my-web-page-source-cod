<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Jetstream\DeleteUser;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserManager extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::select(['id', 'name', 'role', 'nick'])
                ->when(!empty(auth()->user()->id), function ($query, $id) {
                    return $query->where('id', '!=', $id);
                })->orderBy('role', 'ASC')->orderBy('name', 'ASC')
                ->paginate(40),
        ]);
    }

    public function show(User $user): View
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function switchRole(User $user): RedirectResponse
    {
        $user->role = $user->role == UserRole::Admin->value ? UserRole::User->value : UserRole::Admin->value;

        return $user->update()
            ? to_route('user.show', $user)->banner(__('Changed role for :name to :role.', ['name' => $user->name, 'role' => __($user->getNameRole())]))
            : redirect()->refresh()->dangerBanner(__('Failed to change role!'));
    }

    public function destroy(User $user, DeleteUser $deleteUser): RedirectResponse
    {
        $deleteUser->delete($user);

        return to_route('user.index')->banner(__('Deleted user :name.', ['name' => $user->name]));
    }
}
