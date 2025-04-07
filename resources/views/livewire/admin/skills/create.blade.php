<?php

use App\Models\WeaponSkill;
use App\Models\WeaponSkillLevel;
use App\Models\SkillLevelEffect;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string')]
    public string $description = '';

    // スキルレベル関連
    public array $skillLevels = [];

    public function addSkillLevel()
    {
        $nextLevel = count($this->skillLevels) + 1;
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

        // スキルの保存
        $weaponSkill = WeaponSkill::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        // スキルレベルと効果の保存
        foreach ($this->skillLevels as $levelData) {
            $skillLevel = WeaponSkillLevel::create([
                'weapon_skill_id' => $weaponSkill->id,
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
        }

        session()->flash('message', 'スキルが正常に追加されました。');

        // スキル一覧ページへリダイレクト
        $this->redirect(route('admin.weapon-skills.index'), navigate: true);
    }

    public function mount()
    {
        // 初期状態でレベル1を追加
        $this->addSkillLevel();
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
    <div class="bg-gray-800 shadow-sm rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">新規スキル追加</h1>
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

        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 gap-6">
                {{-- 基本情報セクション --}}
                <div class="bg-gray-700 p-4 rounded-md">
                    <h2 class="text-lg font-semibold text-white mb-4">基本情報</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- スキル名 --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">スキル名 <span
                                    class="text-red-600">*</span></label>
                            <input type="text" id="name" wire:model="name" required
                                class="w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- スキル説明 --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-1">スキル説明 <span
                                    class="text-red-600">*</span></label>
                            <textarea id="description" wire:model="description" rows="1" required
                                class="w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white"></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- スキルレベルセクション --}}
                <div class="bg-gray-700 p-4 rounded-md">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-white">スキルレベル設定</h2>
                        <button type="button" wire:click="addSkillLevel"
                            class="px-3 py-1 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm">
                            レベル追加
                        </button>
                    </div>

                    <div class="space-y-4">
                        @foreach ($skillLevels as $levelIndex => $level)
                            <div x-data="{ open: {{ $levelIndex === 0 ? 'true' : 'false' }} }"
                                class="border border-gray-600 rounded-md bg-gray-800 overflow-hidden">
                                {{-- レベル情報ヘッダー --}}
                                <div class="bg-gray-700 p-3 grid grid-cols-12 items-center">
                                    <span
                                        class="font-bold text-lg text-gray-300 col-span-1">Lv.{{ $level['level'] }}</span>

                                    <div class="col-span-9">
                                        <input type="text"
                                            wire:model="skillLevels.{{ $levelIndex }}.effect_description"
                                            placeholder="効果説明（例: 攻撃力が上昇する）"
                                            class="px-3 py-1 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white w-full">
                                        @error("skillLevels.{$levelIndex}.effect_description")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-2 flex items-center justify-end space-x-2">
                                        <button type="button" @click="open = !open"
                                            class="px-2 py-1 bg-gray-500 text-white rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-sm">
                                            <span x-show="!open">詳細を表示</span>
                                            <span x-show="open">詳細を隠す</span>
                                        </button>
                                        <button type="button" wire:click="removeSkillLevel({{ $levelIndex }})"
                                            @if (count($skillLevels) === 1) disabled @endif
                                            class="px-2 py-1 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                            削除
                                        </button>
                                    </div>
                                </div>

                                {{-- 効果設定 (アコーディオンの中身) --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-90"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-90" class="p-3 space-y-2">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-700">
                                            <thead class="bg-gray-700">
                                                <tr>
                                                    <th
                                                        class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                        適用ステータス</th>
                                                    <th
                                                        class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                        効果タイプ</th>
                                                    <th
                                                        class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                        効果値</th>
                                                    <th
                                                        class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                        操作</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                                @foreach ($level['effects'] as $effectIndex => $effect)
                                                    <tr>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <select
                                                                wire:model="skillLevels.{{ $levelIndex }}.effects.{{ $effectIndex }}.effect_status"
                                                                class="w-full px-2 py-1 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white">
                                                                @foreach ($effectStatuses as $value => $label)
                                                                    <option value="{{ $value }}">
                                                                        {{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error("skillLevels.{$levelIndex}.effects.{$effectIndex}.effect_status")
                                                                <p class="mt-1 text-xs text-red-600">{{ $message }}
                                                                </p>
                                                            @enderror
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <select
                                                                wire:model.live="skillLevels.{{ $levelIndex }}.effects.{{ $effectIndex }}.effect_type"
                                                                class="w-full px-2 py-1 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white">
                                                                @foreach ($effectTypes as $value => $label)
                                                                    <option value="{{ $value }}">
                                                                        {{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error("skillLevels.{$levelIndex}.effects.{$effectIndex}.effect_type")
                                                                <p class="mt-1 text-xs text-red-600">{{ $message }}
                                                                </p>
                                                            @enderror
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <div>
                                                                <input type="number"
                                                                    wire:model="skillLevels.{{ $levelIndex }}.effects.{{ $effectIndex }}.effect_value"
                                                                    step="{{ $skillLevels[$levelIndex]['effects'][$effectIndex]['effect_type'] === 'multiply' ? '0.01' : '1' }}"
                                                                    min="0"
                                                                    class="w-full px-2 py-1 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white">

                                                                @if ($skillLevels[$levelIndex]['effects'][$effectIndex]['effect_type'] === 'multiply')
                                                                    <p class="text-xs text-gray-400">例: 1.05 = 5%増加</p>
                                                                @endif

                                                                @error("skillLevels.{$levelIndex}.effects.{$effectIndex}.effect_value")
                                                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <button type="button"
                                                                wire:click="removeEffect({{ $levelIndex }}, {{ $effectIndex }})"
                                                                @if (count($level['effects']) === 1) disabled @endif
                                                                class="px-2 py-1 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                                                削除
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- 効果追加ボタン -->
                                    <div class="flex justify-end mt-2">
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
                    スキルを追加
                </button>
            </div>
        </form>
    </div>
</div>
