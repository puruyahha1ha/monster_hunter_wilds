<div class="mb-8">
    <div class="flex items-center justify-between mb-6 mx-1">
        <h2 class="text-2xl font-bold tracking-tight text-white">
            新着のお知らせ
        </h2>
        <a href="#" class="text-red-400 hover:text-red-300 text-sm font-medium">
            すべて見る →
        </a>
    </div>

    <div class="grid grid-cols-1 gap-2">
        @foreach (['新しいイベントが開催されます', '新しいモンスターが追加されました', '新しい装備が追加されました', '新しいクエストが追加されました', '新しいアイテムが追加されました'] as $index => $news)
            <div
                class="group relative overflow-hidden rounded-lg border border-gray-700 bg-gray-800 transition hover:shadow-md">
                <div class="p-3 flex items-center">
                    <a href="#" class="font-medium text-white hover:text-red-400 flex items-center">
                        <flux:icon.bell class="h-5 w-5 mr-2 text-gray-400" />
                        {{ $news }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
