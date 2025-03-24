<div class="mb-8 rounded-lg border border-gray-700 bg-gray-900 shadow-sm overflow-hidden">
    <div class="border-b border-gray-700 bg-gray-900 px-4 py-3">
        <h3 class="font-semibold text-white flex items-center">
            <flux:icon.arrow-trending-up class="h-5 w-5 mr-2 text-red-600" />
            人気の装備構成
        </h3>
    </div>

    <div class="divide-y divide-gray-700">
        @for ($i = 0; $i < 5; $i++)
            <div class="flex items-center p-4">
                <div
                    class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-gray-800 animate-pulse">
                </div>

                <div class="ml-4 flex-1">
                    <div class="h-5 w-3/4 bg-gray-800 rounded animate-pulse"></div>

                    <div class="mt-2 overflow-x-auto pb-1">
                        <div class="flex gap-1 whitespace-nowrap">
                            @for ($t = 0; $t < 3; $t++)
                                <div class="w-14 h-4 bg-gray-800 rounded animate-pulse"></div>
                            @endfor
                        </div>
                    </div>

                    <div class="mt-2 overflow-x-auto pb-1">
                        <div class="flex gap-1 whitespace-nowrap">
                            @for ($s = 0; $s < 3; $s++)
                                <div class="w-20 h-4 bg-gray-800 rounded animate-pulse"></div>
                            @endfor
                        </div>
                    </div>

                    <div class="mt-1 flex items-center gap-4">
                        <div class="flex items-center">
                            <div class="h-4 w-4 mr-1 bg-gray-800 rounded animate-pulse"></div>
                            <div class="h-4 w-8 bg-gray-800 rounded animate-pulse"></div>
                        </div>
                        <div class="flex items-center">
                            <div class="h-4 w-4 mr-1 bg-gray-800 rounded animate-pulse"></div>
                            <div class="h-4 w-6 bg-gray-800 rounded animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <div class="border-t border-gray-700 p-4">
        <a href="#"
            class="text-sm font-medium text-red-400 hover:text-red-300">
            もっと見る →
        </a>
    </div>
</div>
