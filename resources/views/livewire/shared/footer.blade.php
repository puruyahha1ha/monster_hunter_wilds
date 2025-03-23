<div>
    <footer class="bg-gray-900 border-t border-gray-700">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="text-center text-sm text-white">
                <p>© 2025 モンスターハンターワイルド 総合情報サイト - ファンサイト</p>
                <p class="mt-2">このサイトはCAPCOMの正式なサイトではありません。ゲーム内の画像や名称はCAPCOMの商標です。</p>
            </div>
        </div>
    </footer>

    {{-- SP用フッター --}}
    <div class="sm:hidden fixed bottom-0 inset-x-0 bg-gray-900 border-t border-gray-700 z-10">
        <div class="grid grid-cols-5">
            <a href="#" class="flex flex-col items-center justify-center p-3 text-red-500">
                <flux:icon.home class="h-6 w-6" />
                <span class="text-xs mt-1">ホーム</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-300">
                <flux:icon.magnifying-glass class="h-6 w-6" />
                <span class="text-xs mt-1">検索</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-300 dark:text-gray-300">
                <flux:icon.shield-ellipsis class="h-6 w-6" />
                <span class="text-xs mt-1">装備</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-300 dark:text-gray-300">
                <flux:icon.ghost class="h-6 w-6" />
                <span class="text-xs mt-1">モンスター</span>
            </a>
            @auth
                <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-300 dark:text-gray-300">
                    <flux:icon.cog-6-tooth class="h-6 w-6" />
                    <span class="text-xs mt-1">マイページ</span>
                </a>
            @else
                <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-300 dark:text-gray-300">
                    <flux:icon.log-in class="h-6 w-6" />
                    <span class="text-xs mt-1">ログイン</span>
                </a>
            @endauth
        </div>
    </div>

    <div class="sm:hidden h-10"></div>
</div>
