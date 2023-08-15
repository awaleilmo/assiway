<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            $user = $request->user();
            return redirect()->intended( $user->isAdmin === 1 ? RouteServiceProvider::HOMEADMIN.'?verified=1' : RouteServiceProvider::HOMEMEMBER.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        $user = $request->user();
        return redirect()->intended( $user->isAdmin === 1 ? RouteServiceProvider::HOMEADMIN.'?verified=1' : RouteServiceProvider::HOMEMEMBER.'?verified=1');
    }
}
