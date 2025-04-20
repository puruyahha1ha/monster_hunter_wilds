<?php

use App\Models\Series;
use App\Models\Skill;
use App\Enums\SkillTypes;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

new #[Layout('components.layouts.admin-app')] class extends Component {
    use WithPagination;

    public int $perPage = 10;
    public string $search = '';
    public string $sortField = 'id';
    public string $sortDirection = 'asc';
    public bool $showDeleteModal = false;
    public ?int $deleteSeriesId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function series()
    {
        return Series::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
    }

    #[Computed]
    public function skills()
    {
        return Skill::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete(int $skillId): void
    {
        $this->deleteSeriesId = $skillId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->deleteSeriesId = null;
        $this->showDeleteModal = false;
    }

    public function deleteSeries(): void
    {
        if ($this->deleteSeriesId) {
            try {
                $series = Series::findOrFail($this->deleteSeriesId);
                $seriesName = $series->name;
                $series->delete();

                session()->flash('message', "シリーズ「{$seriesName}」を削除しました。");
            } catch (\Exception $e) {
                session()->flash('error', "削除中にエラーが発生しました: {$e->getMessage()}");
            }
        }

        $this->showDeleteModal = false;
        $this->deleteSeriesId = null;
    }
}; ?>

<div>
    {{-- 検索 --}}
    <div class="mb-4 flex justify-between">
        <input type="text" wire:model.live.debounce.500ms="search"
            class="px-4 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="シリーズ名または説明で検索" />
        <div class="flex space-x-8">
            <a href="{{ route('admin.skills.groups.index') }}"
                class="px-4 py-2 text-white rounded-md bg-blue-500 hover:bg-blue-600" wire:navigate>
                グループスキル一覧
            </a>
            <a href="{{ route('admin.skills.index') }}"
                class="px-4 py-2 text-white rounded-md bg-blue-500 hover:bg-blue-600" wire:navigate>
                スキル一覧
            </a>
        </div>
    </div>
    {{-- シリーズスキル一覧 --}}
    <div class="border border-white rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">シリーズ一覧</h1>
            <a href="{{ route('admin.skills.series.create') }}" wire:navigate
                class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                シリーズ追加
            </a>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('message') }}
            </div>
        @endif
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            操作
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            シリーズ名
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            シリーズ説明
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($this->series() as $series)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.skills.series.show', $series->id) }}" wire:navigate
                                    class="text-blue-600 hover:text-blue-900">詳細</a>
                                <a href="{{ route('admin.skills.series.edit', $series->id) }}" wire:navigate
                                    class="text-yellow-600 hover:text-yellow-900 ml-4">編集</a>
                                <button wire:click="confirmDelete({{ $series->id }})"
                                    class="text-red-600 hover:text-red-900 ml-4">削除</button>
                            </td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">{{ $series->name }}</td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">{{ $series->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                シリーズが見つかりませんでした
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $this->series()->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
                <h3 class="text-xl font-bold text-white mb-4">削除の確認</h3>
                <p class="text-gray-300 mb-6">
                    このシリーズを削除してもよろしいですか？<br>
                    この操作は取り消せません。
                </p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="cancelDelete"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        キャンセル
                    </button>
                    <button wire:click="deleteSeries" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        削除する
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
