<div class="relative overflow-hidden bg-gradient-to-r from-gray-900 to-gray-800">
    <div class="absolute inset-0 opacity-20">
        <svg class="h-full w-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="weapon-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                    <path d="M40,30 L60,30 L50,50 Z" fill="currentColor" opacity="0.4" />
                    <circle cx="25" cy="25" r="5" fill="currentColor" opacity="0.4" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#weapon-pattern)" />
        </svg>
    </div>
    <div class="relative px-6 py-8 sm:py-12 lg:px-8 lg:py-16">
        <div class="mx-auto max-w-3xl">
            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl flex items-center">
                <flux:icon.swords class="h-8 w-8 mr-2 text-red-500" />
                武器データベース
            </h1>
            <p class="mt-4 max-w-2xl text-lg text-gray-300">
                モンスターハンターワイルドのすべての武器を詳細に紹介。各武器の特性や使い方、入手方法までを網羅しています。
            </p>
            <div class="mt-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-grow">
                        <input type="text" placeholder="武器名で検索..." wire:model.live.debounce.300ms="$parent.search"
                            class="block w-full rounded-md bg-gray-700 border-gray-600 py-2 pl-10 pr-3 text-sm placeholder-gray-400 text-white focus:border-red-500 focus:outline-none focus:ring-red-500">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <flux:icon.magnifying-glass class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
