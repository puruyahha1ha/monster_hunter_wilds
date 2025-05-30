<?php

use App\Models\Skill;
use App\Models\User;
use App\Models\Weapon;
use App\Models\Armor;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public int $skillCount;
    public int $userCount;
    public int $weaponCount;
    public int $armorCount;

    public function mount()
    {
        $this->skillCount = Skill::count();
        $this->userCount = User::count();
        $this->weaponCount = Weapon::count();
        $this->armorCount = Armor::count();
    }
}; ?>

<div class="border border-gray-200 rounded-lg p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">管理者ダッシュボード</h1>
        <p class="mt-2 text-gray-400">Monster Hunter Wilds 管理パネルへようこそ</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="{{ route('admin.skills.index') }}" class="bg-emerald-900/30 rounded-lg p-6 hover:bg-emerald-900"
            wire:navigate>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-200 text-sm font-medium">スキル管理</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        {{ $skillCount }}種類
                    </p>
                </div>
                <div class="bg-emerald-800 rounded-full p-3">
                    <flux:icon.cog class="h-6 w-6 text-emerald-200" />
                </div>
            </div>
        </a>

        <a href="{{ route('admin.weapons.index') }}" class="bg-indigo-900/30 rounded-lg p-6 hover:bg-indigo-900"
            wire:navigate>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-200 text-sm font-medium">武器管理</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        {{ $weaponCount }}種類
                    </p>
                </div>
                <div class="bg-indigo-800 rounded-full p-3">
                    <flux:icon.swords class="h-6 w-6 text-indigo-200" />
                </div>
            </div>
        </a>

        <a href="{{ route('admin.armors.index') }}" class="bg-emerald-900/30 rounded-lg p-6 hover:bg-emerald-900"
            wire:navigate>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-200 text-sm font-medium">防具管理</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        {{ $armorCount }}種類
                    </p>
                </div>
                <div class="bg-emerald-800 rounded-full p-3">
                    <flux:icon.swords class="h-6 w-6 text-emerald-200" />
                </div>
            </div>
        </a>

        <a href="{{ route('admin.users.index') }}" class="bg-indigo-900/30 rounded-lg p-6 hover:bg-indigo-900"
            wire:navigate>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-200 text-sm font-medium">ユーザー管理</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        {{ $userCount }}人
                    </p>
                </div>
                <div class="bg-indigo-800 rounded-full p-3">
                    <flux:icon.users class="h-6 w-6 text-indigo-200" />
                </div>
            </div>
        </a>
    </div>
</div>
</div>
