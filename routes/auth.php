<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

    Volt::route('register', 'auth.register')
        ->name('register');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');


// 管理者用
Route::prefix('admin')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Volt::route('login', 'admin.auth.login')
            ->name('admin.login');

        Volt::route('register', 'admin.auth.register')
            ->name('admin.register');

        Volt::route('forgot-password', 'admin.auth.forgot-password')
            ->name('admin.password.request');

        Volt::route('reset-password/{token}', 'admin.auth.reset-password')
            ->name('admin.password.reset');
    });

    Route::post('logout', App\Livewire\Actions\AdminLogout::class)
        ->name('admin.logout');
});
