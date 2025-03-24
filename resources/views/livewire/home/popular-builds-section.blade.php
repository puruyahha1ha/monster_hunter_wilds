<div class="mb-8 rounded-lg border border-gray-700 bg-gray-900 shadow-sm overflow-hidden">
    <div class="border-b border-gray-700 bg-gray-900 px-4 py-3">
        <h3 class="font-semibold text-white flex items-center">
            <flux:icon.arrow-trending-up class="h-5 w-5 mr-2 text-red-600" />
            人気の装備構成
        </h3>
    </div>
    <div class="divide-y divide-gray-700">
        @foreach (['驚異的火力の大剣装備', '回復サポート向け狩猟笛', '超火力ボウガン装備', '生存特化ランス装備', '万能型チャージアックス'] as $index => $build)
            <div class="flex items-center p-4 transition">
                <div
                    class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-red-600 text-white text-sm font-bold">
                    {{ $index + 1 }}
                </div>
                <div class="ml-4 flex-1">
                    <a href="/builds/{{ $index + 1 }}"
                        class="text-sm font-medium text-white hover:text-red-400">
                        <h4>{{ $build }}</h4>
                    </a>
                    {{-- タグ --}}
                    <div class="mt-2 overflow-x-auto pb-1">
                        <div class="flex gap-1 whitespace-nowrap">
                            @foreach (['大剣', '火力', '装備'] as $tag)
                                <a href="#"
                                    class="text-xs px-1.5 py-0.5 bg-gray-800 text-gray-300 rounded hover:bg-gray-700">
                                    {{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    {{-- スキル --}}
                    <div class="mt-2 overflow-x-auto pb-1">
                        <div class="flex gap-1 whitespace-nowrap">
                            @foreach (['攻撃力', '会心率', '火属性攻撃強化'] as $skill)
                                <a href="#"
                                    class="text-xs px-1.5 py-0.5 bg-gray-800 text-gray-300 rounded hover:bg-gray-700">
                                    {{ $skill }} Lv{{ rand(1, 3) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-1 flex items-center gap-4">
                        <div class="flex items-center text-sm text-gray-400">
                            <flux:icon.heart class="mr-1 h-4 w-4" />
                            {{ rand(100, 999) }}
                        </div>
                        <span class="flex items-center text-sm text-gray-400">
                            <flux:icon.chat-bubble-oval-left class="mr-1 h-4 w-4" />
                            {{ rand(10, 99) }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="border-t border-gray-700 p-4">
        <a href="#"
            class="text-sm font-medium text-red-400 hover:text-red-300">
            もっと見る →
        </a>
    </div>
</div>
