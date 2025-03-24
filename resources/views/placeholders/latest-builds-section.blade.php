<div class="mb-8">
    <div class="flex items-center justify-between mb-6 mx-1">
        <h2 class="text-2xl font-bold tracking-tight text-white">
            新着の装備構成
        </h2>
        <a href="#" class="text-red-400 hover:text-red-300 text-sm font-medium">
            すべて見る →
        </a>
    </div>

    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
        @for ($i = 0; $i < 3; $i++)
            <div class="flex flex-col overflow-hidden rounded-lg border shadow-sm border-gray-700 bg-gray-900 p-4">
                {{-- タイトル部分のスケルトン --}}
                <div class="flex items-center mb-2">
                    <div class="h-5 w-3/4 bg-gray-800 rounded animate-pulse"></div>
                </div>

                {{-- タグ部分のスケルトン --}}
                <div class="mt-2 overflow-x-auto pb-1">
                    <div class="flex gap-1 whitespace-nowrap">
                        @for ($t = 0; $t < 4; $t++)
                            <div class="h-4 w-14 bg-gray-800 rounded animate-pulse"></div>
                        @endfor
                    </div>
                </div>

                {{-- スキル部分のスケルトン --}}
                <div class="mt-2 overflow-x-auto pb-1">
                    <div class="flex gap-1 whitespace-nowrap">
                        @for ($s = 0; $s < 5; $s++)
                            <div class="h-4 w-20 bg-gray-800 rounded animate-pulse"></div>
                        @endfor
                    </div>
                </div>

                {{-- 詳細部分のスケルトン --}}
                <div class="mt-2 grid grid-cols-2 gap-1">
                    @for ($d = 0; $d < 8; $d++)
                        <div class="h-6 w-full bg-gray-800 rounded animate-pulse"></div>
                    @endfor
                </div>

                {{-- ユーザー情報とライク数のスケルトン --}}
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-gray-800 animate-pulse"></div>
                        <div class="ml-2">
                            <div class="h-3 w-20 bg-gray-800 rounded animate-pulse"></div>
                            <div class="h-3 w-16 bg-gray-800 rounded animate-pulse mt-1"></div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="h-4 w-4 rounded bg-gray-800 animate-pulse mr-1"></div>
                        <div class="h-4 w-8 bg-gray-800 rounded animate-pulse"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
