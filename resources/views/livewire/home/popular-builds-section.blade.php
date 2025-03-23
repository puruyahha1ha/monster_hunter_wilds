<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold tracking-tight text-white">
            人気の装備構成
        </h2>
        <a href="#" class="text-red-400 hover:text-red-300 text-sm font-medium">
            すべて見る →
        </a>
    </div>

    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
        @foreach(range(0, 2) as $i)
            <div
                class="flex flex-col overflow-hidden rounded-lg border shadow-sm border-gray-700 bg-gray-900 transition hover:shadow-md">
                <div class="flex flex-1 flex-col justify-between p-4">
                    <div>
                        <h3 class="font-semibold text-white">
                            {{ ['火属性特化太刀装備', '高耐久ハンマー装備', '会心特化双剣ビルド'][$i] }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-300 line-clamp-2">
                            {{ ['火力と生存性能を両立した汎用的な太刀装備です。', '被弾を気にせず攻撃できる高防御ハンマー装備です。', '高い会心率で継続的なダメージを出せる双剣装備です。'][$i] }}
                        </p>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-500 text-white">
                                    {{ ['MH', 'TK', 'AK'][$i] }}
                                </span>
                            </div>
                            <div class="ml-2">
                                <p class="text-xs text-gray-400">
                                    {{ ['モンハン名人', 'タケル', 'アカネ'][$i] }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-400">
                            <flux:icon.heart class="h-4 w-4 mr-1" />
                            {{ rand(10, 99) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
