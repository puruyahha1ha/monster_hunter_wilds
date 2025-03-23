<div class="border border-gray-700 bg-gray-900 shadow-sm overflow-hidden">
    <div class="border-b border-gray-700 bg-gray-900 px-4 py-3">
        <h3 class="font-semibold text-white flex items-center">
            <flux:icon.link class="h-5 w-5 mr-2" />
            クイックアクセス
        </h3>
    </div>
    <div class="p-4 grid grid-cols-2 gap-3">
        @foreach ($quickLinks as $quickLink)
            <a href="{{ $quickLink['url'] }}"
                class="flex items-center p-3 rounded-lg border border-gray-700 hover:bg-gray-700 transition"
                wire:navigate>
                <span class="text-sm font-medium text-white">{{ $quickLink['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>
