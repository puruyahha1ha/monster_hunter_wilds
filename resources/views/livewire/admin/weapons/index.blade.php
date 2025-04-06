<?php

use App\Models\Weapon;
use App\Models\WeaponSkill;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin-app')] class extends Component {
    use WithPagination;

    public string $search = '';
    public string $weaponType = '';
    public string $skillFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingWeaponType()
    {
        $this->resetPage();
    }

    public function updatingSkillFilter()
    {
        $this->resetPage();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex items-center justify-center h-56">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
        </div>
        HTML;
    }

    public function with(): array
    {
        $query = Weapon::with(['skills']);

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->weaponType)) {
            $query->where('weapon_type', $this->weaponType);
        }

        if (!empty($this->skillFilter)) {
            $query->whereHas('skills', function ($q) {
                $q->where('weapon_skills.id', $this->skillFilter);
            });
        }

        return [
            'weapons' => $query->orderBy('id', 'desc')->paginate(10),
            'weaponTypes' => Weapon::getWeaponTypes(),
            'weaponSkills' => WeaponSkill::orderBy('name')->get(),
        ];
    }
}; ?>

<div>
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 md:mb-0">武器管理</h1>
            <a href="{{ route('admin.weapons.create') }}" wire:navigate
                class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                新規武器追加
            </a>
        </div>

        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="w-full md:w-1/3">
                <label for="search"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">武器名検索</label>
                <input type="text" id="search" wire:model.live.debounce.300ms="search"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="武器名を入力...">
            </div>
            <div class="w-full md:w-1/3">
                <label for="weaponType"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">武器種別</label>
                <select id="weaponType" wire:model.live="weaponType"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">すべて</option>
                    @foreach ($weaponTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <label for="skillFilter"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">スキルで絞り込み</label>
                <select id="skillFilter" wire:model.live="skillFilter"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">すべて</option>
                    @foreach ($weaponSkills as $skill)
                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            画像
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            武器名
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            武器種別
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            攻撃力
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            属性
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            スキル
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            レア度
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse($weapons as $weapon)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $weapon->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($weapon->image_path)
                                    <img src="{{ asset('storage/' . $weapon->image_path) }}" alt="{{ $weapon->name }}"
                                        class="h-10 w-10 object-cover">
                                @else
                                    <div
                                        class="h-10 w-10 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <flux:icon.no-symbol class="h-6 w-6 text-gray-400" />
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $weapon->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $weapon->weapon_type }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $weapon->attack }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if ($weapon->element_type != 'なし')
                                    <span class="inline-flex items-center">
                                        {{ $weapon->element_type }} {{ $weapon->element_value }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($weapon->skills as $skill)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $skill->name }} Lv.{{ $skill->pivot->level }}
                                        </span>
                                    @empty
                                        -
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    ★{{ $weapon->rarity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.weapons.show', $weapon) }}" wire:navigate
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        詳細
                                    </a>
                                    <a href="{{ route('admin.weapons.edit', $weapon) }}" wire:navigate
                                        class="text-amber-600 hover:text-amber-900 dark:text-amber-400 dark:hover:text-amber-300">
                                        編集
                                    </a>
                                    <a href="{{ route('admin.weapons.delete', $weapon) }}" wire:navigate
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        削除
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                武器が見つかりませんでした
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $weapons->links() }}
        </div>
    </div>
</div>
