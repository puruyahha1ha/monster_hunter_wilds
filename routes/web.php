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
        Volt::route('/dashboard', 'admin.dashboard')->name('admin.dashboard');

        // スキル管理
        Route::prefix('skills')->name('admin.skills.')->group(function () {
            Volt::route('/', 'admin.skills.index')->name('index');
            Volt::route('/create', 'admin.skills.create')->name('create');
            Volt::route('/edit/{skill}', 'admin.skills.edit')->name('edit');
            Volt::route('/show/{skill}', 'admin.skills.show')->name('show');

            // スキルグループ管理
            Route::prefix('groups')->name('groups.')->group(function () {
                Volt::route('/', 'admin.skills.groups.index')->name('index');
                Volt::route('/create', 'admin.skills.groups.create')->name('create');
                Volt::route('/edit/{group}', 'admin.skills.groups.edit')->name('edit');
                Volt::route('/show/{group}', 'admin.skills.groups.show')->name('show');
            });
            // スキルシリーズ管理
            Route::prefix('series')->name('series.')->group(function () {
                Volt::route('/', 'admin.skills.series.index')->name('index');
                Volt::route('/create', 'admin.skills.series.create')->name('create');
                Volt::route('/edit/{series}', 'admin.skills.series.edit')->name('edit');
                Volt::route('/show/{series}', 'admin.skills.series.show')->name('show');
            });
        });

        // 武器管理
        Route::prefix('weapons')->name('admin.weapons.')->group(function () {
            Volt::route('/', 'admin.weapons.index')->name('index');
            Volt::route('/create', 'admin.weapons.create')->name('create');
            Volt::route('/edit/{weapon}', 'admin.weapons.edit')->name('edit');
            Volt::route('/show/{weapon}', 'admin.weapons.show')->name('show');
        });

        // 防具管理
        Route::prefix('armors')->name('admin.armors.')->group(function () {
            Volt::route('/', 'admin.armors.index')->name('index');
            Volt::route('/create', 'admin.armors.create')->name('create');
            Volt::route('/edit/{armor}', 'admin.armors.edit')->name('edit');
            Volt::route('/show/{armor}', 'admin.armors.show')->name('show');
        });

        // ユーザー管理
        Route::prefix('users')->name('admin.users.')->group(function () {
            Volt::route('/', 'admin.users.index')->name('index');
            Volt::route('/create', 'admin.users.create')->name('create');
            Volt::route('/edit/{user}', 'admin.users.edit')->name('edit');
            Volt::route('/show/{user}', 'admin.users.show')->name('show');
        });
    });
});

require __DIR__ . '/auth.php';
