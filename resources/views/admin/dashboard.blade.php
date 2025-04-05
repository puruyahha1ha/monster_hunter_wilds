<x-layouts.admin-app>
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">管理者ダッシュボード</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Monster Hunter Wilds 管理パネルへようこそ</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-indigo-50 dark:bg-indigo-900/30 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-600 dark:text-indigo-400 text-sm font-medium">武器管理</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">14種類</p>
                    </div>
                    <div class="bg-indigo-100 dark:bg-indigo-800 rounded-full p-3">
                        <flux:icon.swords class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                    </div>
                </div>
                <a href="{{ route('admin.weapons.index') }}"
                    class="mt-4 text-sm text-indigo-600 dark:text-indigo-400 font-medium flex items-center">
                    武器管理へ移動
                    <flux:icon.chevron-right class="h-4 w-4 ml-1" />
                </a>
            </div>

            <div class="bg-emerald-50 dark:bg-emerald-900/30 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-600 dark:text-emerald-400 text-sm font-medium">ユーザー管理</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">128人</p>
                    </div>
                    <div class="bg-emerald-100 dark:bg-emerald-800 rounded-full p-3">
                        <flux:icon.users class="h-6 w-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}"
                    class="mt-4 text-sm text-emerald-600 dark:text-emerald-400 font-medium flex items-center">
                    ユーザー管理へ移動
                    <flux:icon.chevron-right class="h-4 w-4 ml-1" />
                </a>
            </div>

            <div class="bg-amber-50 dark:bg-amber-900/30 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-600 dark:text-amber-400 text-sm font-medium">システム情報</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">システム正常</p>
                    </div>
                    <div class="bg-amber-100 dark:bg-amber-800 rounded-full p-3">
                        <flux:icon.server class="h-6 w-6 text-amber-600 dark:text-amber-400" />
                    </div>
                </div>
                <div class="mt-4 text-sm text-amber-600 dark:text-amber-400 font-medium flex items-center">
                    最終更新: {{ now()->format('Y-m-d H:i') }}
                </div>
            </div>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">最近のアクティビティ</h2>
            <div class="space-y-3">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-4 w-4 rounded-full bg-indigo-500 mt-1"></div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700 dark:text-gray-300">新しい武器「マグネティックパルス」が追加されました</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">2時間前</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-4 w-4 rounded-full bg-emerald-500 mt-1"></div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700 dark:text-gray-300">新規ユーザー登録がありました</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">5時間前</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-4 w-4 rounded-full bg-amber-500 mt-1"></div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700 dark:text-gray-300">システムアップデートが完了しました</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">1日前</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-app>
