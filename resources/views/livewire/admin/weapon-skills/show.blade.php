<?php

use App\Models\WeaponSkill;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public WeaponSkill $skill;

    public function with(): array
    {
        return [
            'effectStatuses' => $this->getEffectStatuses(),
            'effectTypes' => $this->getEffectTypes(),
            'weapons' => $this->skill->weapons()->with('sharpnesses')->paginate(5),
        ];
    }

    private function getEffectStatuses(): array
    {
        return [
            'attack' => '攻撃力',
            'defense' => '防御力',
            'sharpness' => '切れ味',
        ];
    }

    private function getEffectTypes(): array
    {
        return [
            'none' => 'なし',
            'add' => '加算',
            'multiply' => '乗算(%)',
        ];
    }
}; ?>

<div>
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">スキル詳細: {{ $skill->name }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.weapon-skills.edit', $skill) }}" wire:navigate
                    class="px-4 py-2 bg-amber-600 text-white rounded-md shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    編集
                </a>
                <a href="{{ route('admin.weapon-skills.index') }}" wire:navigate
                    class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    スキル一覧に戻る
                </a>
            </div>
        </div>

        <!-- スキル基本情報 -->
        <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">基本情報</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">スキル名</p>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $skill->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">作成日時</p>
                    <p class="text-base text-gray-900 dark:text-white">{{ $skill->created_at->format('Y/m/d H:i') }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">説明</p>
                    <p class="text-base text-gray-900 dark:text-white">{{ $skill->description }}</p>
                </div>
            </div>
        </div>

        <!-- スキルレベル情報 -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">スキルレベル</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                レベル
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                効果説明
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                ステータス
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                効果値
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                効果タイプ
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($skill->levels->sortBy('level') as $level)
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    Lv.{{ $level->level }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $level->effect_description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $level->effect_type === 'multiply' ? number_format($level->effect_value, 2) : $level->effect_value }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if ($level->effect_type === 'add')
                                        {{ $levelStatuses[$level->effect_status] ?? $level->effect_status }}
                                        +{{ $level->effect_value }}
                                    @elseif($level->effect_type === 'multiply')
                                        {{ $levelStatuses[$level->effect_status] ?? $level->effect_status }}
                                        ×{{ number_format($level->effect_value, 2) }}
                                        ({{ number_format(($level->effect_value - 1) * 100, 0) }}% 増加)
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $levelTypes[$level->effect_type] ?? $level->effect_type }}
                                    @if ($level->effect_type === 'multiply')
                                        ({{ $level->effect_value }}%)
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    スキルレベルが設定されていません
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 使用武器 -->
        <div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">このスキルを持つ武器
                ({{ $skill->weapons->count() }})</h2>

            @if ($weapons->isEmpty())
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md text-center">
                    <p class="text-gray-500 dark:text-gray-400">このスキルを持つ武器はありません</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
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
                                    レア度
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    攻撃力
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    スキルレベル
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    操作
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($weapons as $weapon)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($weapon->image_path)
                                            <img src="{{ asset('storage/' . $weapon->image_path) }}"
                                                alt="{{ $weapon->name }}" class="h-10 w-10 object-cover">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <flux:icon.no-symbol class="h-6 w-6 text-gray-400" />
                                            </div>
                                        @endif
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $weapon->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $weapon->weapon_type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            ★{{ $weapon->rarity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $weapon->attack }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Lv.{{ $weapon->pivot->level }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.weapons.show', $weapon) }}" wire:navigate
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            詳細
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $weapons->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
