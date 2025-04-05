<header class="bg-white shadow-sm dark:bg-gray-800" x-data="{ mobileMenuOpen: false, profileOpen: false }">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">MH Wilds</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">DB</span>
                </a>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    wire:current="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300"
                    class="text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                    ダッシュボード
                </a>
                <a href="{{ route('admin.weapons.index') }}" wire:navigate
                    wire:current="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300"
                    class="text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                    武器管理
                </a>
                <a href="{{ route('admin.users.index') }}" wire:navigate
                    wire:current="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300"
                    class="text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                    ユーザー管理
                </a>
            </div>

            <div class="flex items-center">
                <button type="button"
                    class="sm:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                    aria-controls="mobile-menu" aria-expanded="false" @click="mobileMenuOpen = !mobileMenuOpen">
                    <span class="sr-only">メニューを開く</span>
                    <flux:icon.bars-3 class="h-6 w-6" />
                </button>

                <div class="ml-3 relative">
                    <div>
                        <button type="button" class="flex rounded-full dark:bg-gray-800" id="user-menu-button"
                            aria-expanded="false" aria-haspopup="true" @click="profileOpen = !profileOpen">
                            <span class="sr-only">ユーザーメニューを開く</span>
                            <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white">
                                <flux:icon.user class="h-5 w-5 text-gray-500" />
                            </div>
                        </button>
                    </div>

                    <div x-show="profileOpen" @click.outside="profileOpen = false"
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-700 dark:ring-gray-600"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95">
                        <span class="block px-4 py-2 text-xs text-gray-500 dark:text-gray-400">
                            {{ auth()->guard('admin')->user() ? auth()->guard('admin')->user()->name : 'Admin' }}
                        </span>
                        <div class="border-t border-gray-200 dark:border-gray-600"></div>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">プロフィール</a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600"
                            role="menuitem" tabindex="-1" id="user-menu-item-1">設定</a>
                        <div class="border-t border-gray-200 dark:border-gray-600"></div>
                        <button wire:click="logout"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-600"
                            role="menuitem" tabindex="-1" id="user-menu-item-2">ログアウト</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sm:hidden" id="mobile-menu" x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }} block px-3 py-2 rounded-md text-base font-medium">
                ダッシュボード
            </a>
            <a href="{{ route('admin.weapons.index') }}"
                class="{{ request()->routeIs('admin.weapons.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }} block px-3 py-2 rounded-md text-base font-medium">
                武器管理
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="{{ request()->routeIs('admin.users.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }} block px-3 py-2 rounded-md text-base font-medium">
                ユーザー管理
            </a>
        </div>
    </div>
</header>
