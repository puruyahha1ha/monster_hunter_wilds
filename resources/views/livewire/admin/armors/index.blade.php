<?php

use App\Models\Armor;
use App\Enums\ArmorTypes;
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
    public ?int $deleteArmorId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function armors()
    {
        return Armor::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function confirmDelete(int $armorId): void
    {
        $this->deleteArmorId = $armorId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->deleteArmorId = null;
        $this->showDeleteModal = false;
    }

    public function deleteArmor(): void
    {
        if ($this->deleteArmorId) {
            try {
                $armor = Armor::findOrFail($this->deleteArmorId);
                $armorName = $armor->name;
                $armor->delete();

                session()->flash('message', "防具「{$armorName}」を削除しました。");
            } catch (\Exception $e) {
                session()->flash('error', "削除中にエラーが発生しました: {$e->getMessage()}");
            }
        }

        $this->showDeleteModal = false;
        $this->deleteArmorId = null;
    }
}; ?>

<div>
    {{-- 検索 --}}
    <div class="mb-4">
        <input type="text" wire:model.live.debounce.500ms="search"
            class="px-4 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="防具名で検索" />
    </div>
    {{-- 防具一覧 --}}
    <div class="border border-white rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">防具一覧</h1>
            <a href="{{ route('admin.armors.create') }}" wire:navigate
                class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                防具追加
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
                            防具名
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            部位
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            レアリティ
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            スロット
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            防御力
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            火耐性
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            水耐性
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            雷耐性
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            氷耐性
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            龍耐性
                        </th>

                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($this->armors() as $armor)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.armors.show', $armor->id) }}" wire:navigate
                                    class="text-blue-600 hover:text-blue-900">詳細</a>
                                <a href="{{ route('admin.armors.edit', $armor->id) }}" wire:navigate
                                    class="text-yellow-600 hover:text-yellow-900 ml-4">編集</a>
                                <button wire:click="confirmDelete({{ $armor->id }})"
                                    class="text-red-600 hover:text-red-900 ml-4">削除</button>
                            </td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">{{ $armor->name }}</td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">{{ $armor->type->label() }}</td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">{{ $armor->rarity }}</td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">
                                @foreach ($armor->slots as $slot)
                                    {{ $slot->size }}
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">{{ $armor->attack }}</td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">{{ $armor->critical_rate }}</td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">{{ $armor->defense }}</td>
                            <td class="px-6 py-4 text-gray-200 whitespace-nowrap">
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center text-gray-400">
                                防具が見つかりませんでした
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $this->armors()->links() }}
        </div>
    </div>

    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
                <h3 class="text-xl font-bold text-white mb-4">削除の確認</h3>
                <p class="text-gray-300 mb-6">
                    この防具を削除してもよろしいですか？<br>
                    この操作は取り消せません。
                </p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="cancelDelete"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        キャンセル
                    </button>
                    <button wire:click="deleteArmor" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        削除する
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
