<?php

use App\Livewire\Home\Page as HomePage;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Livewireを活用した最適化ルーティング
|--------------------------------------------------------------------------
|
| ベストプラクティス: コントローラーではなく、Livewireコンポーネントを
| 直接ルートとしてマッピングすることで、クリーンな設計を実現。
| 
*/

// トップページ
Route::get('/', HomePage::class)->name('home');


Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::get('/dashboard', HomePage::class)->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
