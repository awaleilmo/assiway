<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrafficController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Model
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [BaseController::class, 'HomeIndex'])->name('Home');

Route::get('/profiles', [ProfileController::class, 'homeProfile'])->name("Profiles");

Route::get('/traffic/book/{book}', [TrafficController::class, 'addTrafficBook']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('book', [BookController::class, 'HomeIndex'])->name('HomeBook');

Route::get('/admin/dashboard', function () {
    return Inertia::render('Admin/Index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/update-account', [ProfileController::class, 'updateAccount'])->name('profile.updateAccount');
});

require __DIR__.'/auth.php';
