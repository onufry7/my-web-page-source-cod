<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessTokenRequest;
use App\Models\AccessToken;
use App\Repositories\AccessTokenRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccessTokenController extends Controller
{
    public function index(): View
    {
        return view('access-token.index', [
            'accessTokens' => AccessToken::orderBy('id', 'ASC')->paginate(40),
        ]);
    }

    public function create(): View
    {
        return view('access-token.create');
    }

    public function store(AccessTokenRequest $request, AccessTokenRepository $accessTokenRepository): RedirectResponse
    {
        $accessToken = $accessTokenRepository->store($request);

        return $accessToken
            ? to_route('access-token.show', $accessToken)->banner(__('Added access token :name.', ['name' => $accessToken->token]))
            : to_route('access-token.create')->withInput()->dangerBanner(__('Failed to add access token!'));
    }

    public function show(AccessToken $accessToken): View
    {
        return view('access-token.show', compact('accessToken'));
    }

    public function edit(AccessToken $accessToken): View
    {
        return view('access-token.edit', compact('accessToken'));
    }

    public function update(AccessTokenRequest $request, AccessToken $accessToken): RedirectResponse
    {
        return $accessToken->update($request->validated())
            ? to_route('access-token.show', $accessToken)->banner(__('Updated access token :name.', ['name' => $accessToken->token]))
            : to_route('access-token.edit', compact('accessToken'))->dangerBanner(__('Failed to update access token!'));
    }

    public function destroy(AccessToken $accessToken): RedirectResponse
    {
        return $accessToken->delete()
            ? to_route('access-token.index')->banner(__('Deleted access token :name.', ['name' => $accessToken->token]))
            : to_route('access-token.index')->dangerBanner(__('Failed to delete access token!'));
    }
}
