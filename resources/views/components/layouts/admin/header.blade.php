<header class="bg-gray-800 shadow-sm" x-data="{ mobileMenuOpen: false, profileOpen: false }">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <span class="text-xl font-bold text-indigo-400">MH Wilds</span>
                    <span class="ml-2 text-sm font-medium text-gray-400">DB</span>
                </a>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                    wire:current="bg-indigo-900 text-indigo-300">
                    ダッシュボード
                </a>
                <a href="{{ route('admin.weapons.index') }}" wire:navigate
                    class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                    wire:current="bg-indigo-900 text-indigo-300">
                    武器管理
                </a>
                <a href="{{ route('admin.armors.index') }}" wire:navigate
                    class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                    wire:current="bg-indigo-900 text-indigo-300">
                    防具管理
                </a>
                <a href="{{ route('admin.skills.index') }}" wire:navigate
                    class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                    wire:current="bg-indigo-900 text-indigo-300">
                    スキル管理
                </a>
                <a href="{{ route('admin.users.index') }}" wire:navigate
                    class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                    wire:current="bg-indigo-900 text-indigo-300">
                    ユーザー管理
                </a>
            </div>

            <div class="flex items-center">
                <button type="button"
                    class="sm:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-gray-300"
                    aria-controls="mobile-menu" aria-expanded="false" @click="mobileMenuOpen = !mobileMenuOpen">
                    <span class="sr-only">メニューを開く</span>
                    <flux:icon.bars-3 class="h-6 w-6" />
                </button>

                <div class="hidden ml-3 relative sm:block">
                    <div>
                        <button type="button" class="flex rounded-full bg-gray-800" id="user-menu-button"
                            aria-expanded="false" aria-haspopup="true" @click="profileOpen = !profileOpen">
                            <span class="sr-only">ユーザーメニューを開く</span>
                            <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white">
                                <flux:icon.user class="h-5 w-5 text-white" />
                            </div>
                        </button>
                    </div>

                    <div x-show="profileOpen" @click.outside="profileOpen = false"
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-gray-700 py-1 shadow-lg ring-1 ring-gray-600 ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95">
                        <span class="block px-4 py-2 text-xs text-gray-400">
                            {{ auth()->guard('admin')->user() ? auth()->guard('admin')->user()->name : 'Admin' }}
                        </span>
                        <div class="border-t border-gray-600"></div>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">プロフィール</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600"
                            role="menuitem" tabindex="-1" id="user-menu-item-1">設定</a>
                        <div class="border-t border-gray-600"></div>
                        <button wire:click="logout"
                            class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-600"
                            role="menuitem" tabindex="-1" id="user-menu-item-2">ログアウト</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- モバイルメニュー --}}
    <div class="fixed inset-0 z-40 sm:hidden" x-show="mobileMenuOpen" x-cloak>
        {{-- 背景オーバーレイ --}}
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity" x-show="mobileMenuOpen"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="mobileMenuOpen = false">
        </div>

        {{-- サイドナビゲーション --}}
        <div class="fixed inset-y-0 right-0 w-full max-w-xs bg-gray-800 overflow-y-auto" x-show="mobileMenuOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">

            <div class="p-4 flex items-center justify-between border-b border-gray-700">
                <h2 class="text-lg font-medium text-white">メニュー</h2>
                <button type="button" @click="mobileMenuOpen = false" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">メニューを閉じる</span>
                    <flux:icon.x-mark class="h-6 w-6" />
                </button>
            </div>

            <div class="divide-y divide-gray-700">
                <div class="py-3 px-4">
                    <div class="flex items-center mb-4">
                        <div
                            class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white mr-3">
                            <flux:icon.user class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">
                                {{ auth()->guard('admin')->user() ? auth()->guard('admin')->user()->name : 'Admin' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                管理者
                            </p>
                        </div>
                    </div>
                    <button wire:click="logout"
                        class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        ログアウト
                    </button>
                </div>

                <nav class="py-2">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate
                        wire:current="bg-indigo-900/30 text-indigo-300"
                        class="flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700/30">
                        <flux:icon.home class="h-5 w-5 mr-3 text-gray-400" />
                        ダッシュボード
                    </a>
                    <a href="{{ route('admin.weapons.index') }}" wire:navigate
                        wire:current="bg-indigo-900/30 text-indigo-300"
                        class="flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700/30">
                        <flux:icon.swords class="h-5 w-5 mr-3 text-gray-400" />
                        武器管理
                    </a>
                    <a href="{{ route('admin.armors.index') }}" wire:navigate
                        wire:current="bg-indigo-900/30 text-indigo-300"
                        class="flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700/30">
                        <flux:icon.shield class="h-5 w-5 mr-3 text-gray-400" />
                        防具管理
                    </a>
                    <a href="{{ route('admin.skills.index') }}" wire:navigate
                        wire:current="bg-indigo-900/30 text-indigo-300"
                        class="flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700/30">
                        <flux:icon.biceps-flexed class="h-5 w-5 mr-3 text-gray-400" />
                        スキル管理
                    </a>
                    <a href="{{ route('admin.users.index') }}" wire:navigate
                        wire:current="bg-indigo-900/30 text-indigo-300"
                        class="flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700/30">
                        <flux:icon.users class="h-5 w-5 mr-3 text-gray-400" />
                        ユーザー管理
                    </a>
                </nav>

                <div class="py-4 px-4">
                    <div class="flex items-center">
                        <flux:icon.cog-6-tooth class="h-5 w-5 text-gray-400 mr-3" />
                        <a href="#" class="text-sm text-gray-300 hover:text-indigo-400">
                            設定
                        </a>
                    </div>
                    <div class="flex items-center mt-3">
                        <flux:icon.question-mark-circle class="h-5 w-5 text-gray-400 mr-3" />
                        <a href="#" class="text-sm text-gray-300 hover:text-indigo-400">
                            ヘルプ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
