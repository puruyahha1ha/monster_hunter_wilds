<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::prefix('admin')->group(function () {
    Route::middleware(['auth:admin'])->group(function () {
        // ダッシュボード
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        })->name('admin.home');
        Route::view('/dashboard', 'admin.dashboard')
            ->name('admin.dashboard');

        // 武器管理
        Route::prefix('weapons')->name('admin.weapons.')->group(function () {
            Volt::route('/', 'admin.weapons.index')
                ->name('index');
            Volt::route('/create', 'admin.weapons.create')
                ->name('create');
            Volt::route('/edit/{weapon}', 'admin.weapons.edit')
                ->name('edit');
            Volt::route('/show/{weapon}', 'admin.weapons.show')
                ->name('show');
            Volt::route('/delete/{weapon}', 'admin.weapons.delete')
                ->name('delete');
            Volt::route('/confirm-delete/{weapon}', 'admin.weapons.confirm-delete')
                ->name('confirm-delete');
        });

        // ユーザー管理
        Route::prefix('users')->name('admin.users.')->group(function () {
            Volt::route('/', 'admin.users.index')
                ->name('index');
            Volt::route('/create', 'admin.users.create')
                ->name('create');
            Volt::route('/edit/{user}', 'admin.users.edit')
                ->name('edit');
            Volt::route('/show/{user}', 'admin.users.show')
                ->name('show');
            Volt::route('/delete/{user}', 'admin.users.delete')
                ->name('delete');
            Volt::route('/confirm-delete/{user}', 'admin.users.confirm-delete')
                ->name('confirm-delete');
        });

        // スキル管理
        Route::prefix('skills')->name('admin.skills.')->group(function () {
            Volt::route('/', 'admin.skills.index')
                ->name('index');
            Volt::route('/create', 'admin.skills.create')
                ->name('create');
            Volt::route('/edit/{skill}', 'admin.skills.edit')
                ->name('edit');
            Volt::route('/show/{skill}', 'admin.skills.show')
                ->name('show');
            Volt::route('/delete/{skill}', 'admin.skills.delete')
                ->name('delete');
        });
    });
});

require __DIR__ . '/auth.php';
