<?php

use App\Enums\ArmorTypes;
use App\Models\Armor;
use App\Models\SkillLevel;
use App\Models\Group;
use App\Models\Series;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;

new #[Layout('components.layouts.admin-app')] class extends Component {
    #[Validate('required|integer', as: 'グループ')]
    public ?int $group_id = null;
    public array $groups = [];
    #[Validate('required|integer', as: 'シリーズ')]
    public ?int $series_id = null;
    public array $series = [];
    #[Validate('required|string', as: '防具名')]
    public string $name = '';
    #[Validate('required|string', as: '部位')]
    public string $type = ArmorTypes::HEAD->value;
    #[Validate('required|integer|min:1|max:8', as: 'レアリティ')]
    public int $rarity = 1;
    #[Validate('required|integer', as: '防御力')]
    public int $defense = 0;
    #[Validate('required|integer', as: '火耐性')]
    public int $fireResistance = 0;
    #[Validate('required|integer', as: '水耐性')]
    public int $waterResistance = 0;
    #[Validate('required|integer', as: '雷耐性')]
    public int $thunderResistance = 0;
    #[Validate('required|integer', as: '氷耐性')]
    public int $iceResistance = 0;
    #[Validate('required|integer', as: '龍耐性')]
    public int $dragonResistance = 0;

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

    public function mount(): void
    {
        // グループの取得
        $this->groups = Group::all()->pluck('name', 'id')->toArray();
        // シリーズの取得
        $this->series = Series::all()->pluck('name', 'id')->toArray();
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
    }

    public function createArmor(): void
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // 防具の登録
                $armor = Armor::create([
                    'name' => $this->name,
                    'group_id' => $this->group_id,
                    'series_id' => $this->series_id,
                    'type' => $this->type,
                    'rarity' => $this->rarity,
                    'defense' => $this->defense,
                    'fire_resistance' => $this->fireResistance,
                    'water_resistance' => $this->waterResistance,
                    'thunder_resistance' => $this->thunderResistance,
                    'ice_resistance' => $this->iceResistance,
                    'dragon_resistance' => $this->dragonResistance,
                ]);

                // 防具スロットの登録
                foreach ($this->slots as $slot) {
                    $armor->slots()->create([
                        'size' => $slot['size'],
                        'position' => $slot['position'],
                    ]);
                }

                // 防具スキルの登録
                if (!empty($this->relatedLevels)) {
                    $armor->skillLevels()->sync($this->relatedLevels);
                }
            });

            // 入力値をリセット
            $this->reset(['name', 'type', 'rarity', 'defense']);

            // 成功時の処理
            session()->flash('message', '防具が正常に登録されました。');
        } catch (\Exception $e) {
            // エラー時の処理
            session()->flash('error', '防具の登録に失敗しました。' . $e->getMessage());
        }
    }

    public function attributes(): array
    {
        return [
            'name' => '防具名',
            'type' => '防具種',
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
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">防具登録</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-gray-300 text-lg font-medium mb-2">
                        防具名
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" wire:model="name"
                        class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3"
                        placeholder="防具名を入力してください" />
                    @if ($errors->has('name'))
                        <p class="text-red-500 text-sm mt-1">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-gray-300 text-lg font-medium mb-2">
                            防具種
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="type" wire:model="type"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3">
                            @foreach (ArmorTypes::cases() as $armorType)
                                <option value="{{ $armorType->value }}">{{ $armorType->label() }}</option>
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
                        <label for="defense" class="block text-gray-300 text-lg font-medium mb-2">
                            防御力
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
                    <div>
                        <label for="group_id" class="block text-gray-300 text-lg font-medium mb-2">
                            グループ
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="group_id" wire:model="group_id"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3">
                            <option value="">選択してください</option>
                            @foreach ($this->groups as $id => $groupName)
                                <option value="{{ $id }}">{{ $groupName }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('group_id'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('group_id') }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <label for="series_id" class="block text-gray-300 text-lg font-medium mb-2">
                            シリーズ
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="series_id" wire:model="series_id"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3">
                            <option value="">選択してください</option>
                            @foreach ($this->series as $id => $seriesName)
                                <option value="{{ $id }}">{{ $seriesName }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('series_id'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('series_id') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    <div>
                        <label for="element" class="block text-gray-300 text-lg font-medium mb-2">
                            火耐性
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="fireResistance" wire:model="fireResistance" min="-20"
                            max="20"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                        @if ($errors->has('fireResistance'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('fireResistance') }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <label for="element" class="block text-gray-300 text-lg font-medium mb-2">
                            水耐性
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="waterResistance" wire:model="waterResistance" min="-20"
                            max="20"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                        @if ($errors->has('waterResistance'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('waterResistance') }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <label for="element" class="block text-gray-300 text-lg font-medium mb-2">
                            雷耐性
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="thunderResistance" wire:model="thunderResistance" min="-20"
                            max="20"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                        @if ($errors->has('thunderResistance'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('thunderResistance') }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <label for="element" class="block text-gray-300 text-lg font-medium mb-2">
                            氷耐性
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="iceResistance" wire:model="iceResistance" min="-20"
                            max="20"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                        @if ($errors->has('iceResistance'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('iceResistance') }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <label for="element" class="block text-gray-300 text-lg font-medium mb-2">
                            龍耐性
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="dragonResistance" wire:model="dragonResistance" min="-20"
                            max="20"
                            class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                        @if ($errors->has('dragonResistance'))
                            <p class="text-red-500 text-sm mt-1">
                                {{ $errors->first('dragonResistance') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="block text-gray-300 text-lg font-medium mb-2">
                        防具スキル
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

            <h2 class="text-2xl font-bold text-white my-6 border-b border-gray-700 py-2">防具スキル</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between mb-6">
                    {{-- スキル検索 --}}
                    <input type="text" id="search" wire:model.live.debounce.500ms="search"
                        class="px-4 py-2 w-full md:w-1/2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="防具スキル名または説明で検索" />
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
                    <a href="{{ route('admin.armors.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white text-center rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        防具一覧へ
                    </a>
                    <button wire:click.prevent="createArmor"
                        class="px-4 py-2 bg-blue-500 text-white text-center rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        防具登録
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
