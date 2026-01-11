<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth', 'is.admin'])
    ->get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::middleware(['auth', 'is.admin'])
    ->post('/register', [RegisteredUserController::class, 'store'])
    ->name('register.store');

require __DIR__.'/settings.php';
