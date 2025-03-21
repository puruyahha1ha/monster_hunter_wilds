<div
    class="sm:hidden fixed bottom-0 inset-x-0 bg-gray-900 dark:bg-gray-900 border-t border-gray-700 dark:border-gray-700 z-10">
    <div class="grid grid-cols-5">
        <a href="#" class="flex flex-col items-center justify-center p-3 text-red-500 dark:text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            <span class="text-xs mt-1">ホーム</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-300 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <span class="text-xs mt-1">検索</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-300 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.5 12.5 7 20l.5-7.5L4.5 8 13 6z" />
                <path d="M14.5 5.5 12 2l-1 3.5-3 1L11.5 9 10 13l7-6-2.5-1.5Z" />
            </svg>
            <span class="text-xs mt-1">装備</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-300 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 6h18M3 12h18M3 18h18" />
            </svg>
            <span class="text-xs mt-1">モンスター</span>
        </a>
        <button @click="$dispatch('toggle-mobile-menu')"
            class="flex flex-col items-center justify-center p-3 text-gray-300 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" x2="20" y1="12" y2="12" />
                <line x1="4" x2="20" y1="6" y2="6" />
                <line x1="4" x2="20" y1="18" y2="18" />
            </svg>
            <span class="text-xs mt-1">メニュー</span>
        </button>
    </div>
</div>
