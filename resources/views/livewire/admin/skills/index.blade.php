<?php

use App\Models\WeaponSkill;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin-app')] class extends Component {
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
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
        $query = WeaponSkill::query()->with(['levels', 'weapons']);

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%');
        }

        return [
            'skills' => $query->orderBy('name')->paginate(10),
        ];
    }
}; ?>

<div>
    <div class="bg-gray-800 shadow-sm rounded-lg p-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white mb-4 md:mb-0">スキル管理</h1>
            <a href="{{ route('admin.weapon-skills.create') }}" wire:navigate
                class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                新規スキル追加
            </a>
        </div>

        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="w-full">
                <label for="search" class="block text-sm font-medium text-gray-300 mb-1">スキル名・説明検索</label>
                <input type="text" id="search" wire:model.live.debounce.300ms="search"
                    class="w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white"
                    placeholder="スキル名または説明を入力...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            スキル名
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            説明
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            最大レベル
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            使用武器数
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse($skills as $skill)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $skill->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                {{ $skill->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400 max-w-md truncate">
                                {{ $skill->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $skill->levels->max('level') ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $skill->weapons->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.weapon-skills.show', $skill) }}" wire:navigate
                                        class="text-indigo-400 hover:text-indigo-300">
                                        詳細
                                    </a>
                                    <a href="{{ route('admin.weapon-skills.edit', $skill) }}" wire:navigate
                                        class="text-amber-400 hover:text-amber-300">
                                        編集
                                    </a>
                                    <a href="{{ route('admin.weapon-skills.delete', $skill) }}" wire:navigate
                                        class="text-red-400 hover:text-red-300">
                                        削除
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-400">
                                スキルが見つかりませんでした
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $skills->links() }}
        </div>
    </div>
</div>
