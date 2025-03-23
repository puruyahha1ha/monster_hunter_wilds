<div x-data="{ mobileMenuOpen: false }">
    <header class="fixed top-0 inset-x-0 bg-gray-900 shadow z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex items-center">
                    {{-- サイトタイトル --}}
                    <div class="flex flex-shrink-0 items-center">
                        <div class="flex items-center space-x-2">
                            <flux:icon.site-logo class="h-8 w-8 text-red-500" />
                            <div>
                                <span class="text-base font-semibold text-white">MH Wilds</span>
                                <span class="ml-1 text-xs text-gray-400">DB</span>
                            </div>
                        </div>
                    </div>

                    {{-- PC用メインメニュー --}}
                    <nav class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href=""
                            class="inline-flex items-center border-b-2 border-red-500 px-1 pt-1 text-sm font-medium text-white"
                            wire:navigate>ホーム</a>
                        <a href=""
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-500 hover:text-gray-100"
                            wire:navigate>武器</a>
                        <a href=""
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-500 hover:text-gray-100"
                            wire:navigate>防具</a>
                        <a href=""
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-500 hover:text-gray-100"
                            wire:navigate>モンスター</a>
                        <a href=""
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-500 hover:text-gray-100"
                            wire:navigate>コミュニティ</a>
                    </nav>
                </div>

                <div class="hidden sm:flex sm:items-center">
                    @auth
                        <div class="flex-shrink-0">
                            <a href="#"
                                class="relative inline-flex items-center gap-x-1.5 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                マイページ
                            </a>
                        </div>
                        <div class="sm:ml-3 sm:flex sm:items-center">
                            <a href="#"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:text-white">
                                ログアウト
                            </a>
                        </div>
                    @else
                        <div class="flex-shrink-0">
                            <a href="#"
                                class="relative inline-flex items-center gap-x-1.5 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                登録
                            </a>
                        </div>
                        <div class="sm:ml-3 sm:flex sm:items-center">
                            <a href="#"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:text-white">
                                ログイン
                            </a>
                        </div>
                    @endauth
                </div>

                {{-- SP用メニューボタン --}}
                <div class="flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = true" type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                        <flux:icon.bars-3 class="h-6 w-6" />
                    </button>
                </div>
            </div>
        </div>

        {{-- モバイルメニュー (右からスライド) --}}
        <div x-cloak x-show="mobileMenuOpen" x-transition:enter="transition transform duration-500"
            x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition transform duration-500" x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="sm:hidden fixed inset-y-0 right-0 z-40 w-64 bg-gray-900 shadow-xl">
            <div class="h-16 flex items-center justify-between px-4 border-b border-gray-700">
                <div class="flex items-center space-x-2">
                    <flux:icon.site-logo class="h-8 w-8 text-red-500" />
                    <div>
                        <span class="text-base font-semibold text-white">MH Wilds</span>
                        <span class="ml-1 text-xs text-gray-400">DB</span>
                    </div>
                </div>
                <button @click="mobileMenuOpen = false" class="text-gray-300 hover:text-white">
                    <flux:icon.x-mark class="h-6 w-6" />
                </button>
            </div>
            <div class="space-y-1 py-3 px-4">
                <a href="#" class="block py-2 text-base font-medium text-red-500 hover:bg-gray-800 rounded-md">
                    ホーム
                </a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white rounded-md">
                    武器
                </a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white rounded-md">
                    防具
                </a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white rounded-md">
                    モンスター
                </a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white rounded-md">
                    アイテム
                </a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white rounded-md">
                    マップ
                </a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white rounded-md">
                    コミュニティ
                </a>
            </div>
            <div class="border-t border-gray-700 py-4 px-4 space-y-3">
                <a href="#"
                    class="w-full flex items-center justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                    登録
                </a>
                <a href="#"
                    class="w-full flex items-center justify-center rounded-md border border-gray-600 px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800">
                    ログイン
                </a>
            </div>
        </div>

        {{-- オーバーレイ背景 --}}
        <div x-cloak x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
            class="sm:hidden fixed inset-0 bg-black z-30 flex justify-start items-center"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <flux:icon.site-logo class="h-40 w-40 text-red-500" />
        </div>
    </header>

    <!-- ヘッダー分の余白 -->
    <div class="h-16"></div>
</div>
