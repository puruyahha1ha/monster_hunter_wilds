<?php

use App\Enums\SkillTypes;
use App\Models\Skill;
use App\Models\SkillLevel;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public Skill $skill;

    public function mount(Skill $skill): void
    {
        // 初期値の設定
        $this->skill = $skill;
    }
}; ?>

<div>
    <div class="rounded-lg border-gray-700 border p-8 bg-gray-850 shadow-xl">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">スキル詳細</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        スキル名
                    </p>
                    <p class="w-full text-white">
                        {{ $skill->name }}
                    </p>

                </div>
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2" for="description">
                        スキル説明
                    </p>
                    <p class="w-full text-white">
                        {{ $skill->description }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        最大レベル
                    </p>
                    <p class="w-30 text-white">
                        {{ $skill->max_level }}
                    </p>
                </div>

                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        スキルタイプ
                    </p>
                    <p class="w-full text-white">
                        {{ SkillTypes::from($skill->type->value)->label() }}
                    </p>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-white my-6 border-b border-gray-700 py-2">スキルレベル</h2>
        <div class="space-y-4">
            @foreach ($skill->levels as $level)
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        レベル {{ $level->level }} 説明
                    </p>
                    <p class="w-full text-white">
                        {{ $level->description }}
                    </p>
                </div>
            @endforeach

            <div class="grid grid-cols-3 gap-6">
                <a href="{{ route('admin.skills.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white text-center rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    スキル一覧へ
                </a>
                <a href="{{ route('admin.skills.edit', $skill->id) }}"
                    class="px-4 py-2 bg-blue-500 text-white text-center rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    スキル編集
                </a>
                <button wire:click="$emit('openModal', 'admin.skills.delete', {{ json_encode(['skill' => $skill]) }})"
                    class="px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    スキル削除
                </button>
            </div>
        </div>
    </div>
</div>
