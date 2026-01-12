<?php

use App\Livewire\Konstruksi\MyTakeList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Logistik\UploadSap;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
// global
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// admin
Route::middleware(['auth', 'is.admin'])
    ->get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::middleware(['auth', 'is.admin'])
    ->post('/register', [RegisteredUserController::class, 'store'])
    ->name('register.store');

//logistik
Route::prefix('logistik')->middleware(['auth', 'role:logistik'])->group(function () {
    Route::get('/upload-sap', UploadSap::class)->name('logistik.upload-sap');
});
//konstruksi
Route::prefix('konstruksi')->middleware(['auth', 'role:konstruksi'])->group(function () {
    Route::get('/my-take-list', MyTakeList::class)->name('konstruksi.my-take-list');
});
//akuntansi



require __DIR__ . '/settings.php';
