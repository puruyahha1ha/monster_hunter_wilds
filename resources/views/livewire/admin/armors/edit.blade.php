<?php

use App\Enums\ElementTypes;
use App\Enums\WeaponTypes;
use App\Models\Weapon;
use App\Models\SkillLevel;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public Weapon $weapon;
    #[Validate('required|string', as: '武器名')]
    public string $name = '';
    #[Validate('required|string|in:great_sword,long_sword,sword_and_shield,dual_blades,hammer,hunting_horn,lance,gunlance,switch_axe,charge_blade,insect_glaive,light_bowgun,heavy_bowgun,bow', as: '武器種')]
    public string $type = WeaponTypes::GREAT_SWORD->value;
    #[Validate('required|integer|min:1|max:8', as: 'レアリティ')]
    public int $rarity = 1;
    #[Validate('required|integer', as: '攻撃力')]
    public int $attack = 100;
    #[Validate('required|integer', as: 'クリティカル率')]
    public int $critical_rate = 0;
    #[Validate('required|string|in:none,fire,water,thunder,ice,dragon,poison,paralyze,sleep,explosion', as: '属性')]
    public string $element = ElementTypes::NONE->value;
    #[Validate('required|integer', as: '属性値')]
    public int $element_attack = 0;
    #[Validate('required|integer', as: '防御力ボーナス')]
    public int $defense = 0;

    #[
        Validate(
            [
                'slots' => 'array',
                'slots.*.size' => 'required|integer|min:0|max:3',
                'slots.*.position' => 'required|integer|min:1|max:3',
            ],
            attribute: [
                'slots' => 'スロット',
                'slots.*.size' => 'スロットサイズ',
                'slots.*.position' => 'スロット位置',
            ],
        ),
    ]
    public array $slots = [
        1 => [
            'size' => 0,
            'position' => 1,
        ],
        2 => [
            'size' => 0,
            'position' => 2,
        ],
        3 => [
            'size' => 0,
            'position' => 3,
        ],
    ];

    public function mount(Weapon $weapon): void
    {
        // 初期値の設定
        $this->weapon = $weapon;
        $this->name = $weapon->name;
        $this->type = $weapon->type->value;
        $this->rarity = $weapon->rarity;
        $this->attack = $weapon->attack;
        $this->critical_rate = $weapon->critical_rate;
        $this->element = $weapon->element->value;
        $this->element_attack = $weapon->element_attack;
        $this->defense = $weapon->defense;

        foreach ($weapon->slots as $slot) {
            if (isset($this->slots[$slot['position']])) {
                $this->slots[$slot['position']]['size'] = $slot['size'];
            }
        }

        foreach ($weapon->skillLevels as $skillLevel) {
            $this->showLevels[] = [
                'id' => $skillLevel->id,
                'name' => $skillLevel->skill->name,
                'level' => $skillLevel->level,
            ];
            $this->relatedLevels[] = $skillLevel->id;
        }
    }

    public string $search = '';

    #[Computed]
    public function skillLevels(): object
    {
        return SkillLevel::whereHas('skill', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->with('skill')
            ->limit(10)
            ->get();
    }

    public array $showLevels = [];
    public array $relatedLevels = [];

    public function addSkill(int $skillLevelId): void
    {
        // すでに追加されているか確認
        foreach ($this->showLevels as $level) {
            if (isset($level['id']) && $level['id'] === $skillLevelId) {
                return;
            }
        }

        // スキルレベル情報を取得
        $skillLevel = SkillLevel::with('skill')->find($skillLevelId);

        if ($skillLevel) {
            // 配列へ追加
            $newLevel = [
                'id' => $skillLevel->id,
                'name' => $skillLevel->skill->name,
                'level' => $skillLevel->level,
            ];

            // 配列が空の場合は新規作成、そうでなければ追加
            if (empty($this->showLevels)) {
                $this->showLevels = [$newLevel];
                $this->relatedLevels = [$newLevel['id']];
            } else {
                $this->showLevels[] = $newLevel;
                $this->relatedLevels[] = $newLevel['id'];
            }
        }
    }

    // 追加したスキルを削除する機能も追加
    public function removeSkill(int $index): void
    {
        if (isset($this->showLevels[$index])) {
            $skillName = $this->showLevels[$index]['name'] ?? '';
            $skillLevel = $this->showLevels[$index]['level'] ?? '';

            unset($this->showLevels[$index]);
            // 配列のキーを振り直し
            $this->showLevels = array_values($this->showLevels);
        }

        // スキルレベルのIDを削除
        if (isset($this->relatedLevels[$index])) {
            unset($this->relatedLevels[$index]);
            // 配列のキーを振り直し
            $this->relatedLevels = array_values($this->relatedLevels);
        }
    }

    public function updateWeapon(): void
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // 武器の編集
                $this->weapon->update([
                    'name' => $this->name,
                    'type' => $this->type,
                    'rarity' => $this->rarity,
                    'attack' => $this->attack,
                    'critical_rate' => $this->critical_rate,
                    'element' => $this->element,
                    'element_attack' => $this->element_attack,
                    'defense' => $this->defense,
                ]);

                // 武器スロットの更新
                $this->weapon->slots()->delete();
                // スロットの登録
                foreach ($this->slots as $slot) {
                    $this->weapon->slots()->create([
                        'size' => $slot['size'],
                        'position' => $slot['position'],
                    ]);
                }

                // 武器スキルの更新
                $this->weapon->skillLevels()->detach();
                // スキルレベルの登録
                if (!empty($this->relatedLevels)) {
                    $this->weapon->skillLevels()->sync($this->relatedLevels);
                }
            });

            // 成功時の処理
            session()->flash('message', '武器が正常に更新されました。');
        } catch (\Exception $e) {
            // エラー時の処理
            session()->flash('error', '武器の更新に失敗しました。' . $e->getMessage());
        }
    }

    public function attributes(): array
    {
        return [
            'name' => '武器名',
            'type' => '武器種',
            'rarity' => 'レアリティ',
            'attack' => '攻撃力',
            'critical_rate' => 'クリティカル率',
            'element' => '属性',
            'element_attack' => '属性値',
            'slots' => 'スロット',
            'slots.*.size' => 'スロットサイズ',
            'slots.*.position' => 'スロット位置',
        ];
    }
}; ?>

<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="rounded-lg border-gray-700 border p-8 bg-gray-850 shadow-xl">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">武器更新</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-gray-300 text-lg font-medium mb-2">
                        武器名
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" wire:model="name"
                        class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3"
                        placeholder="武器名を入力してください" />
                    @if ($errors->has('name'))
                        <p class="text-red-500 text-sm mt-1">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-gray-300 text-lg font-medium mb-2">
                            武器種
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="type" wire:model="type"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3">
                            @foreach (WeaponTypes::cases() as $weaponType)
                                <option value="{{ $weaponType->value }}">{{ $weaponType->label() }}</option>
                            @endforeach
                        </select><br>
                        @if ($errors->has('type'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('type') }}
                            </p>
                        @endif
                    </div>

                    <div>
                        <label for="rarity" class="block text-gray-300 text-lg font-medium mb-2">
                            レアリティ
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="rarity" wire:model="rarity"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3">
                            @for ($rarity = 1; $rarity <= 8; $rarity++)
                                <option value="{{ $rarity }}">{{ $rarity }}</option>
                            @endfor
                        </select><br>
                        @if ($errors->has('rarity'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('rarity') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- スロット --}}
                <div class="grid grid-cols-3 gap-6">
                    @for ($i = 1; $i <= 3; $i++)
                        <div>
                            <label for="slots.{{ $i }}.size"
                                class="block text-gray-300 text-lg font-medium mb-2">
                                スロット {{ $i }} サイズ
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="slots.{{ $i }}.size"
                                wire:model="slots.{{ $i }}.size" min="0" max="3"
                                class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                            @if ($errors->has("slots.$i.size"))
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $errors->first("slots.$i.size") }}
                                </p>
                            @endif
                        </div>
                    @endfor
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="attack" class="block text-gray-300 text-lg font-medium mb-2">
                            攻撃力
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="attack" wire:model="attack" min="1"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                        @if ($errors->has('attack'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('attack') }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <label for="critical_rate" class="block text-gray-300 text-lg font-medium mb-2">
                            クリティカル率
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="critical_rate" wire:model="critical_rate" min="-100"
                            max="100"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                        @if ($errors->has('critical_rate'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('critical_rate') }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <label for="defense" class="block text-gray-300 text-lg font-medium mb-2">
                            防御力ボーナス
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="defense" wire:model="defense" min="0" max="100"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                        @if ($errors->has('defense'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('defense') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="element" class="block text-gray-300 text-lg font-medium mb-2">
                            属性
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="element" wire:model="element"
                            class="w-40 md:w-50 bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3">
                            @foreach (ElementTypes::cases() as $elementType)
                                <option value="{{ $elementType->value }}">{{ $elementType->label() }}</option>
                            @endforeach
                        </select><br>
                        @if ($errors->has('element'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('element') }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <label for="element_attack" class="block text-gray-300 text-lg font-medium mb-2">
                            属性値
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="element_attack" wire:model="element_attack" min="1"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                        @if ($errors->has('element_attack'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('element_attack') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        武器スキル
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($showLevels as $index => $level)
                            <div class="flex justify-between items-center border-gray-200 border rounded-md p-3">
                                <div>
                                    <span class="text-white font-medium">
                                        {{ $level['name'] }}Lv.{{ $level['level'] }}
                                    </span>
                                </div>
                                <button wire:click.prevent="removeSkill({{ $index }})"
                                    class="text-red-500 hover:text-red-700">
                                    <flux:icon.x-mark class="w-4 h-4" />
                                </button>
                            </div>
                        @empty
                            <p class="border-gray-200 border rounded-md p-3 text-gray-500 text-center">スキルなし</p>
                        @endforelse
                    </div>
                    @if ($errors->has('levels'))
                        <p class="text-red-500 text-sm mt-1">
                            {{ $errors->first('levels') }}
                        </p>
                    @endif
                </div>
            </div>

            <h2 class="text-2xl font-bold text-white my-6 border-b border-gray-700 py-2">武器スキル</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between mb-6">
                    {{-- スキル検索 --}}
                    <input type="text" id="search" wire:model.live.debounce.500ms="search"
                        class="px-4 py-2 w-full md:w-1/2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="武器スキル名または説明で検索" />
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                    スキル名
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                    スキルレベル
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                    スキル説明
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                    操作
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($this->skillLevels as $skillLevel)
                                <tr>
                                    <td class="px-6 py-4 text-gray-200 whitespace-nowrap">{{ $skillLevel->id }}</td>
                                    <td class="px-6 py-4 text-gray-200 whitespace-nowrap">
                                        {{ $skillLevel->skill->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-200 whitespace-nowrap">
                                        {{ $skillLevel->level }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-200 whitespace-nowrap">
                                        {{ $skillLevel->description }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-200 whitespace-nowrap">
                                        <button wire:click.prevent="addSkill({{ $skillLevel->id }})"
                                            class="text-blue-500 hover:text-blue-700">追加</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-gray-200 text-center">
                                        スキルが見つかりませんでした。
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <a href="{{ route('admin.weapons.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white text-center rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        武器一覧へ
                    </a>
                    <button wire:click.prevent="updateWeapon"
                        class="px-4 py-2 bg-blue-500 text-white text-center rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        武器更新
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
