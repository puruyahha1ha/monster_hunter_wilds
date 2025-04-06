<?php

use App\Models\WeaponSkill;
use App\Models\WeaponSkillLevel;
use App\Models\SkillLevelEffect; // Missing import
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public WeaponSkill $skill;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string')]
    public string $description = '';

    // スキルレベル関連
    public array $skillLevels = [];
    public array $deletedLevelIds = [];
    public array $deletedEffectIds = []; // Missing declaration

    public function addSkillLevel()
    {
        $nextLevel = empty($this->skillLevels) ? 1 : max(array_column($this->skillLevels, 'level')) + 1;
        $this->skillLevels[] = [
            'level' => $nextLevel,
            'effect_description' => '',
            'effects' => [
                [
                    'effect_status' => 'attack',
                    'effect_value' => 0,
                    'effect_type' => 'none',
                ],
            ],
        ];
    }

    public function removeSkillLevel($index)
    {
        // Store ID for deletion if available
        if (!empty($this->skillLevels[$index]['id'])) {
            $this->deletedLevelIds[] = $this->skillLevels[$index]['id'];
        }

        unset($this->skillLevels[$index]);
        $this->skillLevels = array_values($this->skillLevels);

        // レベル番号を振り直す
        foreach ($this->skillLevels as $i => $level) {
            $this->skillLevels[$i]['level'] = $i + 1;
        }
    }

    public function addEffect($levelIndex)
    {
        $this->skillLevels[$levelIndex]['effects'][] = [
            'effect_status' => 'attack',
            'effect_value' => 0,
            'effect_type' => 'none',
        ];
    }

    public function removeEffect($levelIndex, $effectIndex)
    {
        // Store ID for deletion if available
        if (!empty($this->skillLevels[$levelIndex]['effects'][$effectIndex]['id'])) {
            $this->deletedEffectIds[] = $this->skillLevels[$levelIndex]['effects'][$effectIndex]['id'];
        }

        if (count($this->skillLevels[$levelIndex]['effects']) > 1) {
            unset($this->skillLevels[$levelIndex]['effects'][$effectIndex]);
            $this->skillLevels[$levelIndex]['effects'] = array_values($this->skillLevels[$levelIndex]['effects']);
        }
    }

    public function save()
    {
        // 乗算の場合は小数点を許可するカスタムバリデーション
        $effectValueRules = [];

        foreach ($this->skillLevels as $levelIndex => $level) {
            foreach ($level['effects'] as $effectIndex => $effect) {
                $path = "skillLevels.{$levelIndex}.effects.{$effectIndex}.effect_value";

                if ($effect['effect_type'] === 'multiply') {
                    $effectValueRules[$path] = 'required|numeric|min:0';
                } else {
                    $effectValueRules[$path] = 'required|integer|min:0';
                }
            }
        }

        // 基本バリデーション
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'skillLevels.*.effect_description' => 'required|string',
            'skillLevels.*.effects.*.effect_status' => 'required|string|in:attack,defense,sharpness',
            'skillLevels.*.effects.*.effect_type' => 'required|string|in:none,add,multiply',
        ];

        // 効果値のルールをマージ
        $rules = array_merge($rules, $effectValueRules);

        $this->validate($rules);

        // スキルの更新
        $this->skill->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        // 削除するスキルレベル
        if (!empty($this->deletedLevelIds)) {
            WeaponSkillLevel::whereIn('id', $this->deletedLevelIds)->delete();
        }

        // 削除する効果
        if (!empty($this->deletedEffectIds)) {
            SkillLevelEffect::whereIn('id', $this->deletedEffectIds)->delete();
        }

        // スキルレベルと効果の保存または更新
        foreach ($this->skillLevels as $levelData) {
            if (empty($levelData['id'])) {
                // 新規レベル
                $skillLevel = WeaponSkillLevel::create([
                    'weapon_skill_id' => $this->skill->id,
                    'level' => $levelData['level'],
                    'effect_description' => $levelData['effect_description'],
                ]);

                // 効果の保存
                foreach ($levelData['effects'] as $effectData) {
                    SkillLevelEffect::create([
                        'weapon_skill_level_id' => $skillLevel->id,
                        'effect_status' => $effectData['effect_status'],
                        'effect_value' => $effectData['effect_value'],
                        'effect_type' => $effectData['effect_type'],
                    ]);
                }
            } else {
                // 既存レベルの更新
                $skillLevel = WeaponSkillLevel::findOrFail($levelData['id']);
                $skillLevel->update([
                    'level' => $levelData['level'],
                    'effect_description' => $levelData['effect_description'],
                ]);

                // 効果の保存または更新
                foreach ($levelData['effects'] as $effectData) {
                    if (empty($effectData['id'])) {
                        // 新規効果
                        SkillLevelEffect::create([
                            'weapon_skill_level_id' => $skillLevel->id,
                            'effect_status' => $effectData['effect_status'],
                            'effect_value' => $effectData['effect_value'],
                            'effect_type' => $effectData['effect_type'],
                        ]);
                    } else {
                        // 既存効果の更新
                        SkillLevelEffect::where('id', $effectData['id'])->update([
                            'effect_status' => $effectData['effect_status'],
                            'effect_value' => $effectData['effect_value'],
                            'effect_type' => $effectData['effect_type'],
                        ]);
                    }
                }
            }
        }

        session()->flash('message', 'スキルが正常に更新されました。');

        // スキル詳細ページへリダイレクト
        $this->redirect(route('admin.weapon-skills.show', $this->skill), navigate: true);
    }

    public function mount(WeaponSkill $skill)
    {
        $this->skill = $skill;
        $this->name = $skill->name;
        $this->description = $skill->description;
        $this->deletedLevelIds = [];
        $this->deletedEffectIds = [];

        // スキルレベルの読み込み
        $this->skillLevels = [];
        foreach ($skill->levels->sortBy('level') as $level) {
            $this->skillLevels[] = [
                'id' => $level->id,
                'level' => $level->level,
                'effect_description' => $level->effect_description,
                'effects' => $level->effects
                    ->map(function ($effect) {
                        return [
                            'id' => $effect->id,
                            'effect_status' => $effect->effect_status,
                            'effect_value' => $effect->effect_value,
                            'effect_type' => $effect->effect_type,
                        ];
                    })
                    ->toArray(),
            ];
        }

        // スキルレベルがない場合は空のレベルを追加
        if (empty($this->skillLevels)) {
            $this->addSkillLevel();
        }
    }

    public function with(): array
    {
        return [
            'effectStatuses' => $this->getEffectStatuses(),
            'effectTypes' => $this->getEffectTypes(),
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
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">スキル編集: {{ $skill->name }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.weapon-skills.show', $skill) }}" wire:navigate
                    class="px-4 py-2 bg-indigo-500 text-white rounded-md shadow-sm hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    詳細に戻る
                </a>
                <a href="{{ route('admin.weapon-skills.index') }}" wire:navigate
                    class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    スキル一覧に戻る
                </a>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 gap-6">
                {{-- 基本情報セクション --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">基本情報</h2>

                    <div class="grid grid-cols-1 gap-4">
                        {{-- スキル名 --}}
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">スキル名 <span
                                    class="text-red-600">*</span></label>
                            <input type="text" id="name" wire:model="name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- スキル説明 --}}
                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">スキル説明 <span
                                    class="text-red-600">*</span></label>
                            <textarea id="description" wire:model="description" rows="3" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- スキルレベルセクション --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">スキルレベル設定</h2>
                        <button type="button" wire:click="addSkillLevel"
                            class="px-3 py-1 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm">
                            レベル追加
                        </button>
                    </div>

                    <div class="space-y-8">
                        @foreach ($skillLevels as $levelIndex => $level)
                            <div
                                class="border border-gray-200 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 overflow-hidden">
                                <div class="bg-gray-100 dark:bg-gray-700 p-3 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span
                                            class="font-bold text-lg text-gray-700 dark:text-gray-300 mr-3">Lv.{{ $level['level'] }}</span>
                                        <input type="text"
                                            wire:model="skillLevels.{{ $levelIndex }}.effect_description"
                                            placeholder="効果説明（例: 攻撃力が上昇する）"
                                            class="px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white w-96">
                                    </div>
                                    <button type="button" wire:click="removeSkillLevel({{ $levelIndex }})"
                                        @if (count($skillLevels) === 1) disabled @endif
                                        class="px-3 py-1 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                        レベル削除
                                    </button>
                                </div>

                                @error("skillLevels.{$levelIndex}.effect_description")
                                    <p class="mt-1 text-sm text-red-600 px-3">{{ $message }}</p>
                                @enderror

                                <div class="p-3 space-y-4">
                                    <!-- 効果設定 -->
                                    <div class="space-y-3">
                                        @foreach ($level['effects'] as $effectIndex => $effect)
                                            <div
                                                class="grid grid-cols-1 md:grid-cols-12 gap-4 p-3 border border-gray-200 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700">
                                                <!-- 適用ステータス -->
                                                <div class="md:col-span-3">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">適用ステータス
                                                        <span class="text-red-600">*</span></label>
                                                    <select
                                                        wire:model="skillLevels.{{ $levelIndex }}.effects.{{ $effectIndex }}.effect_status"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                        @foreach ($effectStatuses as $value => $label)
                                                            <option value="{{ $value }}">{{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error("skillLevels.{$levelIndex}.effects.{$effectIndex}.effect_status")
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <!-- 効果タイプ -->
                                                <div class="md:col-span-3">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">効果タイプ
                                                        <span class="text-red-600">*</span></label>
                                                    <select
                                                        wire:model.live="skillLevels.{{ $levelIndex }}.effects.{{ $effectIndex }}.effect_type"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                        @foreach ($effectTypes as $value => $label)
                                                            <option value="{{ $value }}">{{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error("skillLevels.{$levelIndex}.effects.{$effectIndex}.effect_type")
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <!-- 効果値 -->
                                                <div class="md:col-span-3">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">効果値
                                                        <span class="text-red-600">*</span></label>
                                                    <!-- 乗算の場合は小数点入力を可能にする -->
                                                    <input
                                                        type="{{ $skillLevels[$levelIndex]['effects'][$effectIndex]['effect_type'] === 'multiply' ? 'number' : 'number' }}"
                                                        wire:model="skillLevels.{{ $levelIndex }}.effects.{{ $effectIndex }}.effect_value"
                                                        step="{{ $skillLevels[$levelIndex]['effects'][$effectIndex]['effect_type'] === 'multiply' ? '0.01' : '1' }}"
                                                        min="0"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                                                    @if ($skillLevels[$levelIndex]['effects'][$effectIndex]['effect_type'] === 'multiply')
                                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                            小数点第2位まで入力可能（例: 1.05 = 5%増加）</p>
                                                    @endif

                                                    @error("skillLevels.{$levelIndex}.effects.{$effectIndex}.effect_value")
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <!-- 削除ボタン -->
                                                <div class="md:col-span-3 flex items-end justify-between">
                                                    <button type="button"
                                                        wire:click="removeEffect({{ $levelIndex }}, {{ $effectIndex }})"
                                                        @if (count($level['effects']) === 1) disabled @endif
                                                        class="px-3 py-2 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                                        効果削除
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- 効果追加ボタン -->
                                    <div class="flex justify-center">
                                        <button type="button" wire:click="addEffect({{ $levelIndex }})"
                                            class="px-3 py-1 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm">
                                            効果を追加
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    変更を保存
                </button>
            </div>
        </form>
    </div>
</div>
