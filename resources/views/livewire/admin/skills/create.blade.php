<?php

use App\Enums\SkillTypes;
use App\Models\Skill;
use App\Models\SkillLevel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    #[Validate('required|string', as: 'スキル名')]
    public string $name = '';
    #[Validate('required|string', as: 'スキル説明')]
    public string $description = '';
    #[Validate('required|integer|min:1|max:7', as: '最大レベル')]
    public int $maxLevel = 1;
    #[Validate('required|string|in:weapon,armor', as: 'スキルタイプ')]
    public string $type = SkillTypes::WEAPON->value;
    #[
        Validate(
            [
                'levels' => 'array',
                'levels.*.description' => 'required|string',
            ],
            attribute: [
                'levels' => 'スキルレベル',
                'levels.*.description' => 'スキルレベル説明',
            ],
        ),
    ]
    public array $levels = [];

    public function mount(): void
    {
        // 初期値の設定
        $this->updatedMaxLevel();
    }

    public function updatedMaxLevel(): void
    {
        if (!isset($this->maxLevel) || !is_numeric($this->maxLevel) || $this->maxLevel < 1) {
            $this->maxLevel = 1;
        } elseif ($this->maxLevel > 7) {
            $this->maxLevel = 7;
        }

        // 最大レベルに応じてlevels配列を調整
        for ($i = 1; $i <= $this->maxLevel; $i++) {
            if (!isset($this->levels[$i])) {
                $this->levels[$i] = [
                    'description' => '',
                ];
            }
        }

        // 最大レベルを超える要素を削除
        foreach (array_keys($this->levels) as $key) {
            if ($key > $this->maxLevel) {
                unset($this->levels[$key]);
            }
        }
    }

    public function createSkill(): void
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // スキルの登録
                $skill = Skill::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'max_level' => $this->maxLevel,
                    'type' => $this->type,
                ]);

                // スキルレベルの登録
                for ($i = 1; $i <= $this->maxLevel; $i++) {
                    if (isset($this->levels[$i])) {
                        $skill->levels()->create([
                            'level' => $i,
                            'description' => $this->levels[$i]['description'],
                        ]);
                    }
                }
            });

            // 入力値をリセット
            $this->reset(['name', 'description', 'maxLevel', 'type', 'levels']);

            // 成功時の処理
            session()->flash('message', 'スキルが正常に登録されました。');
        } catch (\Exception $e) {
            // エラー時の処理
            session()->flash('error', 'スキルの登録に失敗しました。' . $e->getMessage());
        }
    }

    public function attributes(): array
    {
        return [
            'name' => 'スキル名',
            'description' => 'スキル説明',
            'maxLevel' => '最大レベル',
            'type' => 'スキルタイプ',
            'levels' => 'スキルレベル',
            'levels.*.description' => 'レベル説明',
        ];
    }
}; ?>

<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">成功！</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    <div class="rounded-lg border-gray-700 border p-8 bg-gray-850 shadow-xl">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">スキル登録</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-gray-300 text-lg font-medium mb-2">
                        スキル名
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" wire:model="name"
                        class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3"
                        placeholder="スキル名を入力してください" />
                    @if ($errors->has('name'))
                        <p class="text-red-500 text-sm mt-1">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                <div>
                    <label for="description" class="block text-gray-300 text-lg font-medium mb-2">
                        スキル説明
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="description" wire:model="description" autocomplete="off"
                        class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3"
                        placeholder="スキルの効果について説明してください" />
                    @if ($errors->has('description'))
                        <p class="text-red-500 text-sm mt-1">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="maxLevel" class="block text-gray-300 text-lg font-medium mb-2">
                        最大レベル
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="maxLevel" wire:model.live="maxLevel" min="1" max="7"
                        class="w-30 bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3" />
                    @if ($errors->has('maxLevel'))
                        <p class="text-red-500 text-sm mt-1">
                            {{ $errors->first('maxLevel') }}
                        </p>
                    @endif
                </div>

                <div>
                    <label for="type" class="block text-gray-300 text-lg font-medium mb-2">
                        スキルタイプ
                        <span class="text-red-500">*</span>
                    </label>
                    <select id="type" wire:model="type"
                        class="w-30 md:w-50 bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3">
                        @foreach (SkillTypes::cases() as $skillType)
                            <option value="{{ $skillType->value }}">{{ $skillType->label() }}</option>
                        @endforeach
                    </select><br>
                    @if ($errors->has('type'))
                        <p class="text-red-500 text-sm mt-1">
                            {{ $errors->first('type') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-white my-6 border-b border-gray-700 py-2">スキルレベル</h2>
        <div class="space-y-4">
            @for ($i = 1; $i <= $maxLevel; $i++)
                <div>
                    <label for="description{{ $i }}" class="block text-gray-300 text-lg font-medium mb-2">
                        レベル {{ $i }} 説明
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="description{{ $i }}"
                        wire:model="levels.{{ $i }}.description"
                        class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3"
                        placeholder="レベル {{ $i }} のスキル効果について説明してください" />
                    @error("levels.{$i}.description")
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endfor

            <div class="grid grid-cols-2 gap-6">
                <a href="{{ route('admin.skills.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white text-center rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    スキル一覧へ
                </a>
                <button wire:click.prevent="createSkill"
                    class="px-4 py-2 bg-blue-500 text-white text-center rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    スキル登録
                </button>
            </div>
        </div>
    </div>
</div>
