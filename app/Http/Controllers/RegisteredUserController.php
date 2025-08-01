<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Fortify;

class RegisteredUserController extends Controller
{
    protected StatefulGuard $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function create(Request $request): RegisterViewResponse
    {
        return app(RegisterViewResponse::class);
    }

    public function store(Request $request, CreatesNewUsers $creator): RegisterResponse
    {
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }

        event(new Registered($user = $creator->create($request->all())));

        $this->guard->login($user);

        if ($request->input('access-token') && is_string($request->input('access-token'))) {
            $this->useUpAccessToken($request->input('access-token'));
        }

        return app(RegisterResponse::class);
    }

    private function useUpAccessToken(string $token): void
    {
        $accessToken = AccessToken::where(['token' => $token])->first();

        if ($accessToken) {
            $accessToken->markAsUsed();
        }
    }
}
