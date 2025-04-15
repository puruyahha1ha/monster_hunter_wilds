<?php

use App\Models\Skill;
use App\Models\User;
use App\Models\Weapon;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public int $skillCount;
    public int $userCount;
    public int $weaponCount;
    
    public function mount()
    {
        $this->skillCount = Skill::count();
        $this->userCount = User::count();
        $this->weaponCount = Weapon::count();
    }
}; ?>

<div class="border border-gray-200 rounded-lg p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">管理者ダッシュボード</h1>
        <p class="mt-2 text-gray-400">Monster Hunter Wilds 管理パネルへようこそ</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-emerald-900/30 rounded-lg p-6">
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
            <a href="{{ route('admin.skills.index') }}"
                class="mt-4 text-sm text-emerald-400 font-medium flex items-center">
                スキル管理へ移動
                <flux:icon.chevron-right class="h-4 w-4 ml-1" />
            </a>
        </div>

        <div class="bg-indigo-900/30 rounded-lg p-6">
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
            <a href="{{ route('admin.weapons.index') }}"
                class="mt-4 text-sm text-indigo-400 font-medium flex items-center">
                武器管理へ移動
                <flux:icon.chevron-right class="h-4 w-4 ml-1" />
            </a>
        </div>

        <div class="bg-emerald-900/30 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-600 dark:text-emerald-400 text-sm font-medium">ユーザー管理</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                        {{ $userCount }}人
                    </p>
                </div>
                <div class="bg-emerald-100 dark:bg-emerald-800 rounded-full p-3">
                    <flux:icon.users class="h-6 w-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}"
                class="mt-4 text-sm text-emerald-600 dark:text-emerald-400 font-medium flex items-center">
                ユーザー管理へ移動
                <flux:icon.chevron-right class="h-4 w-4 ml-1" />
            </a>
        </div>
    </div>
</div>
