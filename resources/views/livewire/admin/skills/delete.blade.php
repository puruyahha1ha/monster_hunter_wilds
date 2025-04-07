<?php

use App\Models\WeaponSkill;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public WeaponSkill $skill;

    public function delete()
    {
        // スキル削除
        $this->skill->delete();

        session()->flash('message', 'スキルが正常に削除されました。');

        // スキル一覧へリダイレクト
        $this->redirect(route('admin.weapon-skills.index'), navigate: true);
    }

    public function with(): array
    {
        return [
            'weaponsCount' => $this->skill->weapons->count(),
        ];
    }
}; ?>

<div>
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">スキル削除確認</h1>
            <a href="{{ route('admin.weapon-skills.index') }}" wire:navigate
                class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                スキル一覧に戻る
            </a>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-red-50 dark:bg-red-900 p-6 rounded-lg mb-6">
            <div class="flex items-center mb-4">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h2 class="text-lg font-semibold text-red-700 dark:text-red-300">警告: この操作は取り消せません</h2>
            </div>

            <p class="text-red-600 dark:text-red-400 mb-4">
                スキル「{{ $skill->name }}」を削除しようとしています。この操作を実行すると、このスキルに関連するすべてのデータが失われます。
            </p>

            @if ($weaponsCount > 0)
                <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-md mb-4">
                    <p class="text-yellow-700 dark:text-yellow-300 font-medium">
                        このスキルは {{ $weaponsCount }} 個の武器に使用されています。
                    </p>
                    <p class="text-yellow-600 dark:text-yellow-400 mt-2">
                        削除すると、これらの武器からもこのスキルが削除されます。
                    </p>
                </div>
            @endif

            <p class="text-gray-700 dark:text-gray-300 mb-6">
                このスキルを本当に削除しますか？
            </p>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.weapon-skills.show', $skill) }}" wire:navigate
                    class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    キャンセル
                </a>
                <button wire:click="delete" wire:confirm="この操作は取り消せません。本当に削除しますか？"
                    class="px-4 py-2 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    削除する
                </button>
            </div>
        </div>

        <!-- スキル情報 -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">スキル情報</h3>

            <dl class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">スキル名</dt>
                    <dd class="text-base font-medium text-gray-900 dark:text-white">{{ $skill->name }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">説明</dt>
                    <dd class="text-base text-gray-900 dark:text-white">{{ $skill->description }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">レベル数</dt>
                    <dd class="text-base text-gray-900 dark:text-white">{{ $skill->levels->count() }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">使用武器数</dt>
                    <dd class="text-base text-gray-900 dark:text-white">{{ $weaponsCount }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">作成日時</dt>
                    <dd class="text-base text-gray-900 dark:text-white">{{ $skill->created_at->format('Y/m/d H:i') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
