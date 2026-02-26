<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileRequest;

use function Symfony\Component\Clock\now;

class ProfileCompleteController extends Controller
{
    public function edit(Request $request): Response
    {
        $user = new UserResource($request->user()->fresh());

        return Inertia::render('ProfileComplete', [
            'user' => $user,
        ]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        $emailChanged = $user->isDirty('email');

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->has_default_password = false;
        $user->plain_password = null;
        // TODO: remove below line when use smtp mailing and remove below comments
        $user->email_verified_at = now();
        $user->save();

        // if ($emailChanged || ! $user->hasVerifiedEmail()) {
        //     $user->sendEmailVerificationNotification();
        // }

        // if (! $user->hasVerifiedEmail()) {
        //     return Redirect::route('verification.notice')
        //         ->with('status', 'You should check your mailbox and verify your email address.');
        // }

        return Redirect::route('dashboard');
    }
}
