<x-layouts.app :title="__('モンスターハンターワイルド 総合情報サイト')">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <!-- ヒーローセクション -->
        <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-orange-600 to-red-600 mb-8">
            <div class="absolute inset-0 opacity-20">
                <svg class="h-full w-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="monster-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                            <path d="M40,30 L60,30 L50,50 Z" fill="currentColor" opacity="0.4" />
                            <circle cx="25" cy="25" r="5" fill="currentColor" opacity="0.4" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#monster-pattern)" />
                </svg>
            </div>
            
            <div class="relative px-6 py-16 sm:py-24 md:px-12 lg:py-32">
                <div class="max-w-3xl">
                    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        モンスターハンターワイルド<br>
                        <span class="text-yellow-300">総合情報サイト</span>
                    </h1>
                    <p class="mt-6 max-w-2xl text-xl text-white">
                        ハンターのためのデータベースと装備共有コミュニティ。武器、防具、モンスター情報を検索し、ハンター同士でアイデアを共有しましょう。
                    </p>
                    <div class="mt-10 flex flex-wrap gap-4">
                        <flux:button variant="primary" size="lg" class="bg-white text-red-600 hover:bg-yellow-100">
                            <flux:icon.circle-stack variant="micro" class="mr-2" />
                            情報を検索
                        </flux:button>
                        <flux:button variant="outline" size="lg" class="border-white text-white hover:bg-white hover:bg-opacity-10">
                            <flux:icon.user-plus variant="micro" class="mr-2" />
                            アカウント作成
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>

        <!-- メインコンテンツエリア -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <!-- メインコンテンツ -->
            <div class="md:col-span-8">
                <!-- 最新装備構成 -->
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <flux:icon.arrow-down-left class="inline-block mr-2" />
                            最新の装備構成
                        </h2>
                        <a href="#" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                            すべて見る →
                        </a>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="flex flex-col overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-700 bg-white dark:bg-gray-800 transition hover:shadow-md">
                                <div class="relative pb-[60%]">
                                    <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                        <flux:icon.arrow-down-left class="h-16 w-16 text-gray-400 dark:text-gray-500" />
                                    </div>
                                    <div class="absolute top-0 right-0 bg-red-600 text-white text-xs px-2 py-1 m-2 rounded-full">
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
                                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-500 text-white">
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
                                            <flux:icon.heart class="mr-1 h-4 w-4" />
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
                            <flux:icon.arrow-left class="inline-block mr-2" />
                            モンスター図鑑
                        </h2>
                        <a href="#" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                            すべて見る →
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach (['ラージャン', 'マガイマガド', 'ナルガクルガ', 'ディアブロス'] as $monster)
                            <div class="group relative overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 transition hover:shadow-md">
                                <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                    <flux:icon.arrow-left class="h-16 w-16 text-gray-400 dark:text-gray-500 group-hover:text-red-500 dark:group-hover:text-red-400 transition" />
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

                <!-- マップ情報 -->
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <flux:icon.map class="inline-block mr-2" />
                            フィールド情報
                        </h2>
                        <a href="#" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                            すべて見る →
                        </a>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        @foreach (['古代樹の森', '大蟻塚の荒地'] as $map)
                            <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-700 bg-white dark:bg-gray-800 transition hover:shadow-md">
                                <div class="relative pb-[40%]">
                                    <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                        <flux:icon.arrow-left class="h-12 w-12 text-gray-400 dark:text-gray-500" />
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $map }}</h3>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $map === '古代樹の森' ? '豊かな生態系が広がる原生林。多様な環境が形成され、様々な資源が採取できる。' : '広大な荒野に蟻塚が点在する乾燥地帯。砂漠特有の素材が豊富に採取できる。' }}
                                    </p>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                            素材採取
                                        </span>
                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            環境生物
                                        </span>
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
                <div class="mb-8 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
                    <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-4 py-3">
                        <h3 class="font-semibold text-gray-900 dark:text-white flex items-center">
                            <flux:icon.arrow-left class="mr-2 h-5 w-5 text-red-500" />
                            人気の装備構成
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach (['驚異的火力の大剣装備', '回復サポート向け狩猟笛', '超火力ボウガン装備', '生存特化ランス装備', '万能型チャージアックス'] as $index => $build)
                            <div class="flex items-center p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-red-600 text-white text-sm font-bold">
                                    {{ $index + 1 }}
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $build }}</h4>
                                    <div class="mt-1 flex items-center gap-4">
                                        <span class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                            <flux:icon.heart class="mr-1 h-3 w-3" />
                                            {{ rand(100, 999) }}
                                        </span>
                                        <span class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                            <flux:icon.arrow-left class="mr-1 h-3 w-3" />
                                            {{ rand(10, 99) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                        <a href="#" class="text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                            もっと見る →
                        </a>
                    </div>
                </div>

                <!-- ゲーム最新情報 -->
                <div class="mb-8 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
                    <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-4 py-3">
                        <h3 class="font-semibold text-gray-900 dark:text-white flex items-center">
                            <flux:icon.bell class="mr-2 h-5 w-5 text-red-500" />
                            ゲーム最新情報
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ([
                            ['日付' => '2025/03/15', 'タイトル' => '大型アップデートVer.2.0配信決定！'],
                            ['日付' => '2025/03/10', 'タイトル' => '新モンスター「ヌシ・リオレウス」登場'],
                            ['日付' => '2025/03/05', 'タイトル' => '第3回公式大会の詳細発表'],
                            ['日付' => '2025/03/01', 'タイトル' => 'コラボイベント開催中！']
                        ] as $news)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <time class="text-xs text-gray-500 dark:text-gray-400">{{ $news['日付'] }}</time>
                                <h4 class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $news['タイトル'] }}</h4>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                        <a href="#" class="text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                            もっと見る →
                        </a>
                    </div>
                </div>

                <!-- クイックリンク -->
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
                    <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-4 py-3">
                        <h3 class="font-semibold text-gray-900 dark:text-white flex items-center">
                            <flux:icon.link class="mr-2 h-5 w-5 text-red-500" />
                            クイックアクセス
                        </h3>
                    </div>
                    <div class="p-4 grid grid-cols-2 gap-3">
                        @foreach ([
                            ['アイコン' => 'academic-cap', 'ラベル' => '武器データベース'],
                            ['アイコン' => 'academic-cap', 'ラベル' => '防具データベース'],
                            ['アイコン' => 'academic-cap', 'ラベル' => 'モンスター図鑑'],
                            ['アイコン' => 'academic-cap', 'ラベル' => 'アイテム一覧'],
                            ['アイコン' => 'academic-cap', 'ラベル' => 'マップ情報'],
                            ['アイコン' => 'academic-cap', 'ラベル' => 'コミュニティ']
                        ] as $link)
                            <a href="#" class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <flux:icon.{{ $link['アイコン'] }} class="h-5 w-5 text-red-500 mr-2" />
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $link['ラベル'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>