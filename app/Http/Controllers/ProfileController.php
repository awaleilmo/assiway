<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::back()->with('response', [
        'status' => true,
        'color' => 'bg-green-100 text-green-600',
        'message' => 'Data has been saved',
    ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateAccount(Request $request): RedirectResponse
    {
        try{
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'id' => 'required',
            ]);
            if ($validate->fails()) {
                return Redirect::back()->with('response', [
                    'status' => false,
                    'color' => 'bg-red-50 text-red-600',
                    'message' => $validate->errors()->first(),
                ]);
            }
            $form = User::query()->find($request->get('id'));
            $form->setAttribute('name', $request->get('name'));
            $form->setAttribute('email', $request->get('email'));
            $form->setAttribute('phone', $request->get('phone'));
            $form->setAttribute('address', $request->get('address'));
            $form->setAttribute('gender', $request->get('gender'));
            $form->setAttribute('date', $request->get('date'));
            $form->setAttribute('place', $request->get('place'));
            $form->setAttribute('typePhoto', $request->get('typePhoto'));
            $form->setAttribute('photo', $request->get('photo'));
            $form->save();
            return Redirect::back()->with('response', [
                'status' => true,
                'color' => 'bg-green-100 text-green-600 border-green-600 border-2',
                'message' => 'Data has been saved',
            ]);
        } catch (Throwable $th) {
            return Redirect::back()->with('response', [
                'status' => false,
                'color' => 'bg-red-50 text-red-600',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
