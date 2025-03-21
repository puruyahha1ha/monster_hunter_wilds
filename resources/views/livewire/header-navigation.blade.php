<div x-data="{ mobileMenuOpen: false }" @toggle-mobile-menu.window="mobileMenuOpen = !mobileMenuOpen">
    <header class="fixed top-0 inset-x-0 bg-gray-900 dark:bg-gray-900 shadow z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex items-center">
                    <div class="flex flex-shrink-0 items-center">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="size-8 text-red-600 dark:text-red-500">
                                <path d="m14.5 12.5-7.5 7.5.5-7.5-3-4.5L13 6z" />
                                <path d="M14.5 5.5 12 2l-1 3.5-3 1L11.5 9 10 13l7-6-2.5-1.5Z" />
                                <path d="M14.5 12.5 18 17l-7 1-1 4 8.5-7 3.5-3.5-7.5 1Z" />
                            </svg>
                            <div>
                                <span class="text-base font-semibold text-white dark:text-white">MH Wild</span>
                                <span class="ml-1 text-xs text-gray-400 dark:text-gray-400">DB</span>
                            </div>
                        </div>
                    </div>
                    <nav class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="#"
                            class="inline-flex items-center border-b-2 border-red-500 px-1 pt-1 text-sm font-medium text-white dark:text-white">ホーム</a>
                        <a href="#"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-500 hover:text-gray-100 dark:text-gray-300 dark:hover:border-gray-500 dark:hover:text-gray-100">武器</a>
                        <a href="#"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-500 hover:text-gray-100 dark:text-gray-300 dark:hover:border-gray-500 dark:hover:text-gray-100">防具</a>
                        <a href="#"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-500 hover:text-gray-100 dark:text-gray-300 dark:hover:border-gray-500 dark:hover:text-gray-100">モンスター</a>
                        <a href="#"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-500 hover:text-gray-100 dark:text-gray-300 dark:hover:border-gray-500 dark:hover:text-gray-100">コミュニティ</a>
                    </nav>
                </div>

                <!-- モバイルメニューボタン -->
                <div class="flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-300 hover:bg-gray-700 hover:text-white dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                        <template x-if="!mobileMenuOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="4" x2="20" y1="12" y2="12" />
                                <line x1="4" x2="20" y1="6" y2="6" />
                                <line x1="4" x2="20" y1="18" y2="18" />
                            </svg>
                        </template>
                        <template x-if="mobileMenuOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                        </template>
                    </button>
                </div>

                <div class="hidden sm:flex sm:items-center">
                    <div class="flex-shrink-0">
                        <a href="#"
                            class="relative inline-flex items-center gap-x-1.5 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                            登録
                        </a>
                    </div>
                    <div class="sm:ml-3 sm:flex sm:items-center">
                        <a href="#"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:text-white dark:text-gray-300 dark:hover:text-white">ログイン</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- モバイルメニュー (右からスライド) -->
        <div class="sm:hidden fixed inset-y-0 right-0 z-40 w-64 bg-gray-900 dark:bg-gray-900 transform transition-transform ease-in-out duration-300 shadow-xl"
            :class="mobileMenuOpen ? 'translate-x-0' : 'translate-x-full'">
            <div class="h-16 flex items-center justify-between px-4 border-b border-gray-700 dark:border-gray-700">
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="size-8 text-red-600 dark:text-red-500">
                        <path d="m14.5 12.5-7.5 7.5.5-7.5-3-4.5L13 6z" />
                        <path d="M14.5 5.5 12 2l-1 3.5-3 1L11.5 9 10 13l7-6-2.5-1.5Z" />
                    </svg>
                    <span class="text-base font-semibold text-white">MH Wild</span>
                </div>
                <button @click="mobileMenuOpen = false" class="text-gray-300 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="space-y-1 py-3 px-4">
                <a href="#" class="block py-2 text-base font-medium text-red-500 dark:text-red-500">ホーム</a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white rounded-md">武器</a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white rounded-md">防具</a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white rounded-md">モンスター</a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white rounded-md">アイテム</a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white rounded-md">マップ</a>
                <a href="#"
                    class="block py-2 text-base font-medium text-gray-300 hover:bg-gray-800 hover:text-white dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white rounded-md">コミュニティ</a>
            </div>
            <div class="border-t border-gray-700 dark:border-gray-700 py-4 px-4 space-y-3">
                <a href="#"
                    class="w-full flex items-center justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                    登録
                </a>
                <a href="#"
                    class="w-full flex items-center justify-center rounded-md border border-gray-600 dark:border-gray-600 px-3 py-2 text-sm font-medium text-gray-300 dark:text-gray-300 hover:bg-gray-800 dark:hover:bg-gray-800">
                    ログイン
                </a>
            </div>
        </div>

        <!-- オーバーレイ背景 -->
        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
            class="sm:hidden fixed inset-0 bg-black bg-opacity-50 z-30"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    </header>

    <!-- ヘッダー分の余白 -->
    <div class="h-16"></div>
</div>
