<div>
    <div class="mb-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="text-2xl font-bold tracking-tight text-white">
                武器一覧
            </h2>
            <div class="flex flex-wrap gap-2">
                <select wire:model.live="selectedWeaponType"
                    class="rounded-md bg-gray-700 border-gray-600 text-sm text-white focus:border-red-500 focus:ring-red-500">
                    @foreach ($weaponTypes as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <select wire:model.live="sortField"
                    class="rounded-md bg-gray-700 border-gray-600 text-sm text-white focus:border-red-500 focus:ring-red-500">
                    <option value="name">名前順</option>
                    <option value="rarity">レア度順</option>
                    <option value="attack">攻撃力順</option>
                </select>
                <select wire:model.live="sortDirection"
                    class="rounded-md bg-gray-700 border-gray-600 text-sm text-white focus:border-red-500 focus:ring-red-500">
                    <option value="asc">昇順</option>
                    <option value="desc">降順</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-700 bg-gray-900 shadow-sm relative">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <button wire:click="sortBy('name')" class="flex items-center space-x-1 hover:text-white">
                                <span>武器名</span>
                                @if ($sortField === 'name')
                                    <span>
                                        @if ($sortDirection === 'asc')
                                            <flux:icon.chevron-up class="h-4 w-4" />
                                        @else
                                            <flux:icon.chevron-down class="h-4 w-4" />
                                        @endif
                                    </span>
                                @endif
                            </button>
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <button wire:click="sortBy('weapon_type')"
                                class="flex items-center space-x-1 hover:text-white">
                                <span>種類</span>
                                @if ($sortField === 'weapon_type')
                                    <span>
                                        @if ($sortDirection === 'asc')
                                            <flux:icon.chevron-up class="h-4 w-4" />
                                        @else
                                            <flux:icon.chevron-down class="h-4 w-4" />
                                        @endif
                                    </span>
                                @endif
                            </button>
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <button wire:click="sortBy('rarity')" class="flex items-center space-x-1 hover:text-white">
                                <span>レア度</span>
                                @if ($sortField === 'rarity')
                                    <span>
                                        @if ($sortDirection === 'asc')
                                            <flux:icon.chevron-up class="h-4 w-4" />
                                        @else
                                            <flux:icon.chevron-down class="h-4 w-4" />
                                        @endif
                                    </span>
                                @endif
                            </button>
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <button wire:click="sortBy('attack')" class="flex items-center space-x-1 hover:text-white">
                                <span>攻撃力</span>
                                @if ($sortField === 'attack')
                                    <span>
                                        @if ($sortDirection === 'asc')
                                            <flux:icon.chevron-up class="h-4 w-4" />
                                        @else
                                            <flux:icon.chevron-down class="h-4 w-4" />
                                        @endif
                                    </span>
                                @endif
                            </button>
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <span>属性</span>
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <button wire:click="sortBy('affinity')"
                                class="flex items-center space-x-1 hover:text-white">
                                <span>会心率</span>
                                @if ($sortField === 'affinity')
                                    <span>
                                        @if ($sortDirection === 'asc')
                                            <flux:icon.chevron-up class="h-4 w-4" />
                                        @else
                                            <flux:icon.chevron-down class="h-4 w-4" />
                                        @endif
                                    </span>
                                @endif
                            </button>
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <span>スロット</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 bg-gray-900">
                    @forelse($weapons->data as $weapon)
                        <tr class="hover:bg-gray-800 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <a href="/weapons/{{ $weapon->id }}" class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 bg-gray-700 rounded-md flex items-center justify-center">
                                        <flux:icon.swords class="h-6 w-6 text-red-500" />
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-white hover:text-red-400">
                                            {{ $weapon->name }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300">{{ $weapon->weapon_type }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex">
                                    @for ($i = 0; $i < $weapon->rarity; $i++)
                                        <flux:icon.star class="h-4 w-4 text-yellow-400" />
                                    @endfor
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300">{{ $weapon->attack }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if ($weapon->element_type !== 'なし')
                                    <div class="flex items-center">
                                        <span
                                            class="text-sm 
                                            @if ($weapon->element_type === '火') text-red-400
                                            @elseif($weapon->element_type === '水') text-blue-400
                                            @elseif($weapon->element_type === '雷') text-yellow-400
                                            @elseif($weapon->element_type === '氷') text-cyan-400
                                            @elseif($weapon->element_type === '龍') text-purple-400 @endif
                                        ">
                                            {{ $weapon->element_type }} {{ $weapon->element_value }}
                                        </span>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500">-</div>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div
                                    class="text-sm 
                                    @if ($weapon->affinity > 0) text-green-400
                                    @elseif($weapon->affinity < 0) text-red-400
                                    @else text-gray-300 @endif
                                ">
                                    {{ $weapon->affinity > 0 ? '+' : '' }}{{ $weapon->affinity }}%
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex space-x-1">
                                    @if ($weapon->slot_1 > 0)
                                        <div
                                            class="h-5 w-5 rounded-full flex items-center justify-center 
                                            @if ($weapon->slot_1 === 1) bg-gray-500
                                            @elseif($weapon->slot_1 === 2) bg-blue-500
                                            @elseif($weapon->slot_1 === 3) bg-yellow-500
                                            @else bg-red-500 @endif
                                        ">
                                            <span class="text-xs text-white">{{ $weapon->slot_1 }}</span>
                                        </div>
                                    @endif

                                    @if ($weapon->slot_2 > 0)
                                        <div
                                            class="h-5 w-5 rounded-full flex items-center justify-center 
                                            @if ($weapon->slot_2 === 1) bg-gray-500
                                            @elseif($weapon->slot_2 === 2) bg-blue-500
                                            @elseif($weapon->slot_2 === 3) bg-yellow-500
                                            @else bg-red-500 @endif
                                        ">
                                            <span class="text-xs text-white">{{ $weapon->slot_2 }}</span>
                                        </div>
                                    @endif

                                    @if ($weapon->slot_3 > 0)
                                        <div
                                            class="h-5 w-5 rounded-full flex items-center justify-center 
                                            @if ($weapon->slot_3 === 1) bg-gray-500
                                            @elseif($weapon->slot_3 === 2) bg-blue-500
                                            @elseif($weapon->slot_3 === 3) bg-yellow-500
                                            @else bg-red-500 @endif
                                        ">
                                            <span class="text-xs text-white">{{ $weapon->slot_3 }}</span>
                                        </div>
                                    @endif

                                    @if ($weapon->slot_1 === 0 && $weapon->slot_2 === 0 && $weapon->slot_3 === 0)
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                条件に一致する武器はありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ページネーション --}}
        {{-- {{ $weapons->links() }} --}}
    </div>
</div>
