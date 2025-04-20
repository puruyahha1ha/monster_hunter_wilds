<?php

use App\Models\Series;
use App\Models\Skill;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    #[Validate('required|string', as: 'シリーズ名')]
    public string $name = '';
    #[Validate('required|string', as: 'シリーズ説明')]
    public string $description = '';

    public string $search = '';
    public string $showSecondSkill = '';
    public string $showForthSkill = '';
    #[Computed]
    public function skills(): object
    {
        return Skill::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function addSecondSkill(int $skillId): void
    {
        $skill = Skill::find($skillId);
        if ($skill && $skill->name !== $this->showSecondSkill) {
            $this->showSecondSkill = $skill->name;
        }
    }

    public function removeSecondSkill(string $skillName): void
    {
        $this->showSecondSkill = '';
    }

    public function addForthSkill(int $skillId): void
    {
        $skill = Skill::find($skillId);
        if ($skill && $skill->name !== $this->showForthSkill) {
            $this->showForthSkill = $skill->name;
        }
    }

    public function removeForthSkill(string $skillName): void
    {
        $this->showForthSkill = '';
    }

    public function createSeries(): void
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // シリーズの登録
                $group = Series::create([
                    'name' => $this->name,
                    'description' => $this->description,
                ]);

                // シリーズに関連するスキルの登録
                if ($this->showSecondSkill) {
                    $group->skills()->attach(Skill::where('name', $this->showSecondSkill)->first()->id, [
                        'required_parts' => 2,
                    ]);
                }
                if ($this->showForthSkill) {
                    $group->skills()->attach(Skill::where('name', $this->showForthSkill)->first()->id, [
                        'required_parts' => 4,
                    ]);
                }
            });

            // 入力値をリセット
            $this->reset(['name', 'description', 'showSecondSkill', 'showForthSkill', 'search']);

            // 成功時の処理
            session()->flash('message', 'シリーズが正常に登録されました。');
        } catch (\Exception $e) {
            // エラー時の処理
            session()->flash('error', 'シリーズの登録に失敗しました。' . $e->getMessage());
        }
    }
}; ?>

<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    <div class="rounded-lg border-gray-700 border p-8 bg-gray-850 shadow-xl">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-2">シリーズ登録</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-gray-300 text-lg font-medium mb-2">
                        シリーズ名
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" wire:model="name"
                        class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3"
                        placeholder="シリーズ名を入力してください" />
                    @if ($errors->has('name'))
                        <p class="text-red-500 text-sm mt-1">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                <div>
                    <label for="description" class="block text-gray-300 text-lg font-medium mb-2">
                        シリーズ説明
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="description" wire:model="description" autocomplete="off"
                        class="w-full bg-gray-900 border-gray-200 border text-white rounded-md focus:ring-2 focus:ring-gray-500 p-3"
                        placeholder="シリーズの説明を入力してください" />
                    @if ($errors->has('description'))
                        <p class="text-red-500 text-sm mt-1">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>

            <div>
                <p class="block text-gray-300 text-lg font-medium mb-2">
                    発動スキル
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-gray-300 text-md font-medium mb-2">
                            2部位
                            <span class="text-red-500">*</span>
                        </label>
                        @if ($showSecondSkill)
                            <div class="flex justify-between items-center border-gray-200 border rounded-md p-3">
                                <div>
                                    <span class="text-white font-medium">
                                        {{ $showSecondSkill }}
                                    </span>
                                </div>
                                <button wire:click.prevent="removeSecondSkill('{{ $showSecondSkill }}')"
                                    class="text-red-500 hover:text-red-700">
                                    <flux:icon.x-mark class="w-4 h-4" />
                                </button>
                            </div>
                        @else
                            <p class="border-gray-200 border rounded-md p-3 text-gray-500 text-center">スキルなし</p>
                        @endif
                    </div>
                    <div>
                        <label for="name" class="block text-gray-300 text-md font-medium mb-2">
                            4部位
                            <span class="text-red-500">*</span>
                        </label>
                        @if ($showForthSkill)
                            <div class="flex justify-between items-center border-gray-200 border rounded-md p-3">
                                <div>
                                    <span class="text-white font-medium">
                                        {{ $showForthSkill }}
                                    </span>
                                </div>
                                <button wire:click.prevent="removeForthSkill('{{ $showForthSkill }}')"
                                    class="text-red-500 hover:text-red-700">
                                    <flux:icon.x-mark class="w-4 h-4" />
                                </button>
                            </div>
                        @else
                            <p class="border-gray-200 border rounded-md p-3 text-gray-500 text-center">スキルなし</p>
                        @endif
                    </div>
                </div>
                @if ($errors->has('skills'))
                    <p class="text-red-500 text-sm mt-1">
                        {{ $errors->first('skills') }}
                    </p>
                @endif
            </div>
        </div>

        <h2 class="text-2xl font-bold text-white my-6 border-b border-gray-700 py-2">スキル</h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between mb-6">
                {{-- スキル検索 --}}
                <input type="text" id="search" wire:model.live.debounce.500ms="search"
                    class="px-4 py-2 w-full md:w-1/2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="スキル名または説明で検索" />
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                操作
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                スキル名
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                スキル説明
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($this->skills as $skill)
                            <tr>
                                <td class="px-6 py-4 text-gray-200 whitespace-nowrap flex gap-4">
                                    <button wire:click.prevent="addSecondSkill({{ $skill->id }})"
                                        class="text-blue-500 hover:text-blue-700">2部位に追加</button>
                                    <button wire:click.prevent="addForthSkill({{ $skill->id }})"
                                        class="text-blue-500 hover:text-blue-700">4部位に追加</button>
                                </td>
                                <td class="px-6 py-4 text-gray-200 whitespace-nowrap">
                                    {{ $skill->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-200 whitespace-nowrap">
                                    {{ $skill->description }}
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
                <a href="{{ route('admin.skills.groups.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white text-center rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    シリーズ一覧へ
                </a>
                <button wire:click.prevent="createSeries"
                    class="px-4 py-2 bg-blue-500 text-white text-center rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    シリーズ登録
                </button>
            </div>
        </div>
    </div>
</div>
