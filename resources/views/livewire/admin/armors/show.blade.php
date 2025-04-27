<?php

use App\Models\Armor;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public Armor $armor;
    public bool $showDeleteModal = false;
    public ?int $deleteArmorId = null;

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

                $this->redirect(route('admin.armors.index'));
                session()->flash('message', "{$armorName}を削除しました。");
            } catch (\Exception $e) {
                session()->flash('error', "削除中にエラーが発生しました: {$e->getMessage()}");
            }
        }

        $this->showDeleteModal = false;
        $this->deleteArmorId = null;
    }
}; ?>

<div>
    <div class="rounded-lg border-gray-700 border p-8 bg-gray-850 shadow-xl">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">防具詳細</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        防具名
                    </p>
                    <p class="w-full text-white">
                        {{ $armor->name }}
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2" for="description">
                            防具種
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->type->label() }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2" for="description">
                            レアリティ
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->rarity }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="grid grid-cols-3 gap-6">
                    @foreach ($armor->slots as $slot)
                        <div>
                            <p class="block text-gray-300 text-lg font-medium mb-2" for="description">
                                スロット
                            </p>
                            <p class="w-full text-white">
                                {{ $slot->size }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            防御力
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->defense }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            グループ
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->group->name }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            シリーズ
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->series->name }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="grid grid-cols-5 gap-6">
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            火耐性
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->fire_resistance }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            水耐性
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->water_resistance }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            雷耐性
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->thunder_resistance }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            氷耐性
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->ice_resistance }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            龍耐性
                        </p>
                        <p class="w-full text-white">
                            {{ $armor->dragon_resistance }}
                        </p>
                    </div>
                </div>
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        防具スキル
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($armor->skillLevels as $skillLevel)
                            <div>
                                <span class="text-white font-medium">
                                    {{ $skillLevel->skill->name }}Lv.{{ $skillLevel->level }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500">スキルなし</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <a href="{{ route('admin.armors.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white text-center rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    防具一覧へ
                </a>
                <a href="{{ route('admin.armors.edit', $armor->id) }}"
                    class="px-4 py-2 bg-blue-500 text-white text-center rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    防具編集
                </a>
                <button wire:click="confirmDelete({{ $armor->id }})"
                    class="px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    防具削除
                </button>
            </div>
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
