<?php

namespace App\Repositories;

use App\Http\Requests\AccessTokenRequest;
use App\Models\AccessToken;
use App\Services\AccessTokenService;

class AccessTokenRepository
{
    private AccessTokenService $service;

    public function __construct(AccessTokenService $accessTokenService)
    {
        $this->service = $accessTokenService;
    }

    public function store(AccessTokenRequest $request): AccessToken|false
    {
        $accessToken = new AccessToken($request->validated());
        $accessToken->token = AccessToken::generateToken();

        $isSaved = $accessToken->save();

        if ($isSaved) {
            $this->service->sendMail($request->input('email'), $accessToken);
        }

        return $isSaved ? $accessToken : false;
    }
}
