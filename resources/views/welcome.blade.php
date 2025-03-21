<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>モンスターハンターワイルド 総合情報サイト</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <!-- ヘッダー -->
    @livewire('header-navigation')

    <main>
        <!-- ヒーローセクション -->
        <div class="relative overflow-hidden bg-gradient-to-r from-orange-600 to-red-600">
            <div class="absolute inset-0 opacity-20">
                <svg class="h-full w-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="monster-pattern" x="0" y="0" width="100" height="100"
                            patternUnits="userSpaceOnUse">
                            <path d="M40,30 L60,30 L50,50 Z" fill="currentColor" opacity="0.4" />
                            <circle cx="25" cy="25" r="5" fill="currentColor" opacity="0.4" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#monster-pattern)" />
                </svg>
            </div>
            <div class="relative px-6 py-16 sm:py-24 lg:px-8 lg:py-32">
                <div class="mx-auto max-w-3xl">
                    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        モンスターハンターワイルド<br>
                        <span class="text-yellow-300">総合情報サイト</span>
                    </h1>
                    <p class="mt-6 max-w-2xl text-xl text-white">
                        ハンターのためのデータベースと装備共有コミュニティ。武器、防具、モンスター情報を検索し、ハンター同士でアイデアを共有しましょう。
                    </p>
                    <div class="mt-10 flex flex-wrap gap-4">
                        <a href="#"
                            class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-red-600 shadow-sm hover:bg-yellow-100 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            情報を検索
                        </a>
                        <a href="#"
                            class="rounded-md border border-white px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white hover:bg-opacity-10 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <line x1="19" x2="19" y1="8" y2="14" />
                                <line x1="22" x2="16" y1="11" y2="11" />
                            </svg>
                            アカウント作成
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- メインコンテンツ -->
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
                <!-- メインコンテンツ -->
                <div class="md:col-span-8">
                    <!-- 最新装備構成 -->
                    <div class="mb-10">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                最新の装備構成
                            </h2>
                            <a href="#"
                                class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                                すべて見る →
                            </a>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @for ($i = 0; $i < 3; $i++)
                                <div
                                    class="flex flex-col overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-700 bg-white dark:bg-gray-800 transition hover:shadow-md">
                                    <div class="relative pb-[60%]">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-16 w-16 text-gray-400 dark:text-gray-500" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14.5 12.5 7 20l.5-7.5L4.5 8 13 6z" />
                                                <path d="M14.5 5.5 12 2l-1 3.5-3 1L11.5 9 10 13l7-6-2.5-1.5Z" />
                                            </svg>
                                        </div>
                                        <div
                                            class="absolute top-0 right-0 bg-red-600 text-white text-xs px-2 py-1 m-2 rounded-full">
                                            {{ __('New') }}
                                        </div>
                                    </div>
                                    <div class="flex flex-1 flex-col justify-between p-4">
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                                {{ ['火属性特化太刀装備', '高耐久ハンマー装備', '会心特化双剣ビルド'][$i] }}
                                            </h3>
                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                                {{ ['火力と生存性能を両立した汎用的な太刀装備です。', '被弾を気にせず攻撃できる高防御ハンマー装備です。', '高い会心率で継続的なダメージを出せる双剣装備です。'][$i] }}
                                            </p>
                                        </div>
                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <span
                                                        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-500 text-white">
                                                        {{ ['MH', 'TK', 'AK'][$i] }}
                                                    </span>
                                                </div>
                                                <div class="ml-2">
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                                        {{ ['モンハン名人', 'タケル', 'アカネ'][$i] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                                </svg>
                                                {{ rand(10, 99) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- モンスター情報 -->
                    <div class="mb-10">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                モンスター図鑑
                            </h2>
                            <a href="#"
                                class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                                すべて見る →
                            </a>
                        </div>

                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                            @foreach (['ラージャン', 'マガイマガド', 'ナルガクルガ', 'ディアブロス'] as $monster)
                                <div
                                    class="group relative overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 transition hover:shadow-md">
                                    <div
                                        class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-16 w-16 text-gray-400 dark:text-gray-500 group-hover:text-red-500 dark:group-hover:text-red-400 transition"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18M3 12h18M3 18h18" />
                                        </svg>
                                    </div>
                                    <div class="p-3">
                                        <h3 class="font-medium text-gray-900 dark:text-white">{{ $monster }}</h3>
                                        <div class="mt-1 flex items-center text-xs">
                                            <span class="inline-block h-2 w-2 rounded-full bg-red-500 mr-1"></span>
                                            <span class="text-gray-600 dark:text-gray-400">危険度★★★★★</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- サイドバー -->
                <div class="md:col-span-4">
                    <!-- 人気の装備構成 -->
                    <div
                        class="mb-8 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
                        <div
                            class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-4 py-3">
                            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5 text-red-500"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17" />
                                    <polyline points="16 7 22 7 22 13" />
                                </svg>
                                人気の装備構成
                            </h3>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach (['驚異的火力の大剣装備', '回復サポート向け狩猟笛', '超火力ボウガン装備', '生存特化ランス装備', '万能型チャージアックス'] as $index => $build)
                                <div class="flex items-center p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <div
                                        class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-red-600 text-white text-sm font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $build }}</h4>
                                        <div class="mt-1 flex items-center gap-4">
                                            <span class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                                </svg>
                                                {{ rand(100, 999) }}
                                            </span>
                                            <span class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                                                </svg>
                                                {{ rand(10, 99) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                            <a href="#"
                                class="text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                もっと見る →
                            </a>
                        </div>
                    </div>

                    <!-- クイックリンク -->
                    <div
                        class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
                        <div
                            class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-4 py-3">
                            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5 text-red-500"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                                </svg>
                                クイックアクセス
                            </h3>
                        </div>
                        <div class="p-4 grid grid-cols-2 gap-3">
                            @foreach ([['ラベル' => '武器データベース'], ['ラベル' => '防具データベース'], ['ラベル' => 'モンスター図鑑'], ['ラベル' => 'アイテム一覧'], ['ラベル' => 'マップ情報'], ['ラベル' => 'コミュニティ']] as $link)
                                <a href="#"
                                    class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <span
                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ $link['ラベル'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- フッター -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                <p>© 2025 モンスターハンターワイルド 総合情報サイト - ファンサイト</p>
                <p class="mt-2">このサイトはCAPCOMの正式なサイトではありません。ゲーム内の画像や名称はCAPCOMの商標です。</p>
            </div>
        </div>
    </footer>

    <!-- モバイルフッターナビゲーション -->
    @livewire('mobile-footer')

    <!-- モバイルフッター用の余白 -->
    <div class="sm:hidden h-20"></div>

    @livewireScripts
</body>

</html>
