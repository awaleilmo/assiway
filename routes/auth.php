<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TrafficController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {

    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
    Route::post('book/checkIsMyBook', [BookController::class, 'checkIsMyBook']);

    Route::middleware(['verified', 'role:1'])->group(function () {
        Route::prefix('admin')->group( function () {
            Route::get('/dashboard', function () {
                return Inertia::render('Admin/Index');
            })->name('dashboardAdmin');
            Route::get('user', [UserController::class, 'adminIndex'])->name('userAdmin');

            Route::get('/book', [BookController::class, 'AdminIndex'])->name('bookAdmin');
            Route::post('/book', [BookController::class, 'createOrEdit']);
            Route::post('/book/display', [BookController::class, 'displayBook']);
            Route::post('/book/status', [BookController::class, 'updateStatus']);

            Route::get('/invoice', [InvoiceController::class, 'adminIndex'])->name('invoiceAdmin');
        });
    });

    Route::post('/invoice/status', [InvoiceController::class, 'updateStatus']);

    Route::get('/statistic', [TrafficController::class, 'statistics'])->name('statistic');

    Route::middleware(['verified', 'role:0'])->group(function () {
        Route::prefix('member')->group( function () {
            Route::get('/dashboard', [BaseController::class, 'dashboardMember'])->name('dashboardMember');
            Route::post('/invoice', [InvoiceController::class, 'create']);
            Route::get('/invoice', [InvoiceController::class, 'memberIndex'])->name('invoiceMember');
        });
    });
});
