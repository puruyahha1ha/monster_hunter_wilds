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
        @foreach ($latestBuilds as $build)
            <div
                class="flex flex-col overflow-hidden rounded-lg border shadow-sm border-gray-700 bg-gray-900 transition hover:shadow-md">
                <div class="flex flex-1 flex-col justify-between p-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <a class="font-semibold text-white hover:text-red-400"
                                href="/builds/{{ $build->id }}">
                                {{ $build->title }}
                            </a>
                        </div>

                        @if (count($build->tags) > 0)
                            <div class="mt-2 flex flex-wrap gap-1">
                                @foreach ($build->tags as $tag)
                                    <a class="text-xs px-1.5 py-0.5 bg-gray-800 text-gray-300 rounded hover:bg-gray-700"
                                        href="/builds?tag={{ $tag->id }}">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @if (count($build->skills) > 0)
                            <div class="mt-2 flex flex-wrap gap-1">
                                @foreach ($build->skills as $skill)
                                    <span class="text-xs px-1.5 py-0.5 bg-gray-800 text-gray-300 rounded">
                                        {{ $skill->skill->name }} Lv{{ $skill->level }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if ($build->detail)
                            <div class="mt-2 flex flex-wrap gap-1">
                                @foreach ($build->detail as $detail)
                                    <span>
                                        {{ $detail->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if ($build->user->avatar)
                                    <img src="{{ asset($build->user->avatar) }}" alt="{{ $build->user->name }}"
                                        class="h-8 w-8 rounded-full">
                                @else
                                    <flux:icon.user class="h-8 w-8 rounded-full border-2 border-black" />
                                @endif
                            </div>
                            <div class="ml-2">
                                <p class="text-xs text-gray-400">
                                    {{ $build->user->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $build->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-400">
                            <flux:icon.heart class="h-4 w-4 mr-1" />
                            {{ $build->likes->count }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($hasMoreBuilds)
        <div class="mt-6 text-center">
            <button wire:click="loadMore" wire:loading.attr="disabled"
                class="px-2 py-2 bg-gray-800 border border-gray-700 rounded-md text-white hover:bg-gray-700 disabled:opacity-50 transition">
                <span wire:loading.remove wire:target="loadMore">もっと見る</span>
                <span wire:loading wire:target="loadMore" class="flex items-center justify-center">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </span>
            </button>
        </div>
    @endif
</div>
