<?php

namespace App\Services;

use App\Mail\AccessTokenRegisterMail;
use App\Models\AccessToken;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Mail;

class AccessTokenService
{
    public function sendMail(mixed $email, AccessToken $accessToken): ?SentMessage
    {
        return Mail::to($email)->send(new AccessTokenRegisterMail($accessToken));
    }
}
