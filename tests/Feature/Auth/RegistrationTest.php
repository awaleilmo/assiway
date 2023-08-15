<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $user = Auth::user();
    $response->assertRedirect($user['isAdmin'] === 1 ? RouteServiceProvider::HOMEADMIN : RouteServiceProvider::HOMEMEMBER);
});
