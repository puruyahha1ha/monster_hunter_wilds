<?php

use App\Enums\SkillTypes;
use App\Models\Skill;
use App\Models\SkillLevel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    public Skill $skill;
    #[Validate('required|string')]
    public string $name = '';
    #[Validate('required|string')]
    public string $description = '';
    #[Validate('required|integer|min:1|max:10')]
    public int $maxLevel = 1;
    #[Validate('required|string|in:weapon,armor')]
    public string $type = SkillTypes::WEAPON->value;
    #[Validate('array')]
    public array $levels = [];

    public function mount(Skill $skill): void
    {
        // 初期値の設定
        $this->name = $skill->name;
        $this->description = $skill->description;
        $this->maxLevel = $skill->max_level;
        $this->type = $skill->type->value;
        for ($i = 1; $i <= $this->maxLevel; $i++) {
            if (!isset($this->levels[$i])) {
                $this->levels[$i] = [
                    'description' => $skill->levels[$i - 1]->description ?? '',
                ];
            }
        }
    }

    public function updatedMaxLevel(): void
    {
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

    public function editSkill(): void
    {
        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'maxLevel' => 'required|integer|min:1|max:10',
            'type' => 'required|string|in:weapon,armor',
        ];

        // 各レベルのバリデーションルールを追加
        for ($i = 1; $i <= $this->maxLevel; $i++) {
            $rules["levels.{$i}.description"] = 'required|string';
        }

        $this->validate($rules);

        try {
            DB::transaction(function () {
                // スキルの更新
                $this->skill->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'max_level' => $this->maxLevel,
                    'type' => $this->type,
                ]);

                // 既存のレベル数を取得
                $existingLevelsCount = $this->skill->levels()->count();

                // スキルレベルの更新または作成
                foreach ($this->levels as $level => $data) {
                    $this->skill->levels()->updateOrCreate(['level' => $level], ['description' => $data['description']]);
                }

                // 不要になったレベルを削除 (最大レベル縮小時)
                if ($existingLevelsCount > $this->maxLevel) {
                    $this->skill->levels()->where('level', '>', $this->maxLevel)->delete();
                }
            });

            session()->flash('message', 'スキルが正常に更新されました。');
        } catch (\Exception $e) {
            // エラーメッセージを表示
            session()->flash('error', 'スキルの更新に失敗しました。' . $e->getMessage());
            // エラーログに詳細を記録
            \Log::error('スキル更新エラー:', [
                'skill_id' => $this->skill->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
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
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">スキル更新</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-gray-300 text-lg font-medium mb-2">
                        スキル名
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" wire:model="name" autocomplete="name"
                        class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3"
                        placeholder="スキル名を入力してください" />
                    @if ($errors->has('name'))
                        <span class="text-red-500 text-sm mt-1">
                            {{ $errors->first('name') }}
                        </span>
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
                        <span class="text-red-500 text-sm mt-1">
                            {{ $errors->first('description') }}
                        </span>
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
                        <span class="text-red-500 text-sm mt-1">
                            {{ $errors->first('maxLevel') }}
                        </span>
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
                        <span class="text-red-500 text-sm mt-1">
                            {{ $errors->first('type') }}
                        </span>
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
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            @endfor

            <div class="grid grid-cols-3 gap-6">
                <a href="{{ route('admin.skills.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white text-center rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    スキル一覧へ
                </a>
                <button wire:click.prevent="editSkill"
                    class="px-4 py-2 bg-blue-500 text-white text-center rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    スキル更新
                </button>
                <button wire:click="$emit('openModal', 'admin.skills.delete', {{ json_encode(['skill' => $skill]) }})"
                    class="px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    スキル削除
                </button>
            </div>
        </div>
    </div>
</div>
