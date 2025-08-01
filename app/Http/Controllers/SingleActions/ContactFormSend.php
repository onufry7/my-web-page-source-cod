<?php

namespace App\Http\Controllers\SingleActions;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFormSend extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|max:4500',
        ]);

        if (!empty($request->input('firstname'))) {
            return redirect()->route('about')->withInput($request->except('email'))
                ->withFragment('contact')->dangerBanner(__('Failed to send message!'));
        }

        Mail::to(config('mail.from.contact'))->send(new ContactMail($request->all()));

        return redirect()->route('about')->withFragment('contact')->banner(__('Message was sent.'));
    }
}
