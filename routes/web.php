<?php

// use App\Livewire\Konstruksi\MyTakeList;

use Laravel\Prompts\Table;
use App\Livewire\TabelInfo;
use App\Livewire\Logistik\UploadSap;
use Illuminate\Support\Facades\Route;
use App\Livewire\Logistik\ManualInput;
use App\Livewire\Konstruksi\OriginalWork;
use App\Livewire\Akuntansi\ProjectExecution;
use App\Livewire\Akuntansi\ProjectExecutionExport;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

// global
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/tabel-info', TabelInfo::class)
    ->middleware(['auth', 'verified'])
    ->name('tabel-info');

// admin
Route::middleware(['auth', 'is.admin'])
    ->get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::middleware(['auth', 'is.admin'])
    ->post('/register', [RegisteredUserController::class, 'store'])
    ->name('register.store');

Route::middleware(['auth', 'is.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/management-users', App\Livewire\Admin\ManagementUsers::class)
            ->name('management-users');
    });




Route::middleware(['auth'])->group(function () {
    //logistik
    Route::prefix('logistik')
        ->middleware(['auth', 'role:logistik'])
        ->name('logistik.')
        ->group(function () {
            Route::get('/upload-sap', UploadSap::class)->name('upload-sap');
            Route::get('/manual-input', ManualInput::class)->name('manual-input');
        });

    Route::prefix('konstruksi')
        ->middleware('role:konstruksi')
        ->name('konstruksi.')
        ->group(function () {
            Route::get('/my-take-list', App\Livewire\Konstruksi\MyTakeList::class)
                ->name('my-take-list');
        });
    Route::prefix('konstruksi')
        ->middleware('role:konstruksi')
        ->name('konstruksi.')
        ->group(function () {
            Route::get('/real-work', OriginalWork::class)
                ->name('real-work');
        });

    Route::prefix('akuntansi')
        ->middleware('role:akuntansi')
        ->name('akuntansi.')
        ->group(function () {
            Route::get('/my-take-list', App\Livewire\Akuntansi\MyTakeList::class)
                ->name('my-take-list');

            Route::get('/upload-sap', App\Livewire\Akuntansi\UploadSap::class)
                ->name('upload-sap');

            Route::get('/manual-input', App\Livewire\Akuntansi\ManualInput::class)
                ->name('manual-input');
            Route::get('/project-execution', ProjectExecution::class)
                ->name('project-execution');
            Route::get('/project-execution-export', ProjectExecutionExport::class)
                ->name('project-execution-export');
        });
});




require __DIR__ . '/settings.php';
