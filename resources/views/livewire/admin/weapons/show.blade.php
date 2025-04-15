<?php

use App\Models\Weapon;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public Weapon $weapon;
    public bool $showDeleteModal = false;
    public ?int $deleteWeaponId = null;

    public function confirmDelete(int $weaponId): void
    {
        $this->deleteWeaponId = $weaponId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->deleteWeaponId = null;
        $this->showDeleteModal = false;
    }

    public function deleteWeapon(): void
    {
        if ($this->deleteWeaponId) {
            try {
                $weapon = Weapon::findOrFail($this->deleteWeaponId);
                $weaponName = $weapon->name;
                $weapon->delete();

                $this->redirect(route('admin.weapons.index'));
                session()->flash('message', "{$weaponName}を削除しました。");
            } catch (\Exception $e) {
                session()->flash('error', "削除中にエラーが発生しました: {$e->getMessage()}");
            }
        }

        $this->showDeleteModal = false;
        $this->deleteWeaponId = null;
    }
}; ?>

<div>
    <div class="rounded-lg border-gray-700 border p-8 bg-gray-850 shadow-xl">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">武器詳細</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        武器名
                    </p>
                    <p class="w-full text-white">
                        {{ $weapon->name }}
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2" for="description">
                            武器種
                        </p>
                        <p class="w-full text-white">
                            {{ $weapon->type->label() }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2" for="description">
                            レアリティ
                        </p>
                        <p class="w-full text-white">
                            {{ $weapon->rarity }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="grid grid-cols-3 gap-6">
                    @foreach ($weapon->slots as $slot)
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
                            攻撃力
                        </p>
                        <p class="w-full text-white">
                            {{ $weapon->attack }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            クリティカル率
                        </p>
                        <p class="w-full text-white">
                            {{ $weapon->critical_rate }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            防御力ボーナス
                        </p>
                        <p class="w-full text-white">
                            {{ $weapon->defense }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            属性
                        </p>
                        <p class="w-full text-white">
                            {{ $weapon->element->label() }}
                        </p>
                    </div>
                    <div>
                        <p class="block text-gray-300 text-lg font-medium mb-2">
                            属性値
                        </p>
                        <p class="w-full text-white">
                            {{ $weapon->element_attack }}
                        </p>
                    </div>
                </div>
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        武器スキル
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($weapon->skillLevels as $skillLevel)
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
                <a href="{{ route('admin.weapons.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white text-center rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    武器一覧へ
                </a>
                <a href="{{ route('admin.weapons.edit', $weapon->id) }}"
                    class="px-4 py-2 bg-blue-500 text-white text-center rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    武器編集
                </a>
                <button wire:click="confirmDelete({{ $weapon->id }})"
                    class="px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    武器削除
                </button>
            </div>
        </div>
    </div>
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
                <h3 class="text-xl font-bold text-white mb-4">削除の確認</h3>
                <p class="text-gray-300 mb-6">
                    この武器を削除してもよろしいですか？<br>
                    この操作は取り消せません。
                </p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="cancelDelete"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        キャンセル
                    </button>
                    <button wire:click="deleteWeapon" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        削除する
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
