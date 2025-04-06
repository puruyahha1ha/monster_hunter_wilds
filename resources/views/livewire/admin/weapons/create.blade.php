<?php

use App\Models\Weapon;
use App\Models\Sharpness;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string')]
    public string $weapon_type = '';

    #[Validate('required|integer|min:1|max:10')]
    public int $rarity = 1;

    #[Validate('required|integer|min:0')]
    public int $attack = 0;

    #[Validate('required|integer|min:0')]
    public int $defense = 0;

    #[Validate('required|string')]
    public string $element_type = 'なし';

    #[Validate('integer|min:0')]
    public int $element_value = 0;

    #[Validate('integer|min:0|max:4')]
    public int $slot_1 = 0;

    #[Validate('integer|min:0|max:4')]
    public int $slot_2 = 0;

    #[Validate('integer|min:0|max:4')]
    public int $slot_3 = 0;

    #[Validate('nullable|image|max:1024')]
    public $image = null;

    public ?int $parent_weapon_id = null;

    // 通常の切れ味
    #[Validate('integer|min:0')]
    public int $normal_red = 0;

    #[Validate('integer|min:0')]
    public int $normal_orange = 0;

    #[Validate('integer|min:0')]
    public int $normal_yellow = 0;

    #[Validate('integer|min:0')]
    public int $normal_green = 0;

    #[Validate('integer|min:0')]
    public int $normal_blue = 0;

    #[Validate('integer|min:0')]
    public int $normal_white = 0;

    #[Validate('integer|min:0')]
    public int $normal_purple = 0;

    // 匠スキル適用時の切れ味
    #[Validate('integer|min:0')]
    public int $handicraft_red = 0;

    #[Validate('integer|min:0')]
    public int $handicraft_orange = 0;

    #[Validate('integer|min:0')]
    public int $handicraft_yellow = 0;

    #[Validate('integer|min:0')]
    public int $handicraft_green = 0;

    #[Validate('integer|min:0')]
    public int $handicraft_blue = 0;

    #[Validate('integer|min:0')]
    public int $handicraft_white = 0;

    #[Validate('integer|min:0')]
    public int $handicraft_purple = 0;

    public function save()
    {
        $this->validate();

        // 画像パスの処理
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('weapons', 'public');
        }

        // 武器の保存
        $weapon = Weapon::create([
            'name' => $this->name,
            'weapon_type' => $this->weapon_type,
            'rarity' => $this->rarity,
            'attack' => $this->attack,
            'defense' => $this->defense,
            'element_type' => $this->element_type,
            'element_value' => $this->element_value,
            'slot_1' => $this->slot_1,
            'slot_2' => $this->slot_2,
            'slot_3' => $this->slot_3,
            'image_path' => $imagePath,
            'parent_weapon_id' => $this->parent_weapon_id,
        ]);

        // 通常の切れ味の保存
        Sharpness::create([
            'weapon_id' => $weapon->id,
            'is_handicraft' => 0,
            'red' => $this->normal_red,
            'orange' => $this->normal_orange,
            'yellow' => $this->normal_yellow,
            'green' => $this->normal_green,
            'blue' => $this->normal_blue,
            'white' => $this->normal_white,
            'purple' => $this->normal_purple,
        ]);

        // 匠スキル適用時の切れ味の保存
        Sharpness::create([
            'weapon_id' => $weapon->id,
            'is_handicraft' => 1,
            'red' => $this->handicraft_red,
            'orange' => $this->handicraft_orange,
            'yellow' => $this->handicraft_yellow,
            'green' => $this->handicraft_green,
            'blue' => $this->handicraft_blue,
            'white' => $this->handicraft_white,
            'purple' => $this->handicraft_purple,
        ]);

        session()->flash('message', '武器が正常に追加されました。');

        // 武器一覧ページへリダイレクト
        $this->redirect(route('admin.weapons.index'), navigate: true);
    }

    public function mount(?int $parent_id = null)
    {
        if ($parent_id) {
            $this->parent_weapon_id = $parent_id;
            $parentWeapon = Weapon::find($parent_id);

            if ($parentWeapon) {
                // 親武器から一部の情報を引き継ぐ
                $this->weapon_type = $parentWeapon->weapon_type;
                $this->rarity = min($parentWeapon->rarity + 1, 10); // レア度は最大10
            }
        }
    }

    public function with(): array
    {
        return [
            'weaponTypes' => Weapon::getWeaponTypes(),
            'elementTypes' => Weapon::getElementTypes(),
            'parentWeapons' => Weapon::orderBy('name')->get(['id', 'name']),
        ];
    }
}; ?>


<div>
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">新規武器追加</h1>
            <a href="{{ route('admin.weapons.index') }}" wire:navigate
                class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                武器一覧に戻る
            </a>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- 基本情報セクション --}}
                <div class="col-span-1 md:col-span-2 bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">基本情報</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- 武器名 --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">武器名 <span
                                    class="text-red-600">*</span></label>
                            <input type="text" id="name" wire:model="name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- 武器種別 --}}
                        <div>
                            <label for="weapon_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">武器種別 <span class="text-red-600">*</span></label>
                            <select id="weapon_type" wire:model="weapon_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @foreach($weaponTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('weapon_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        {{-- レア度 --}}
                        <div>
                            <label for="rarity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">レア度 <span class="text-red-600">*</span></label>
                            <input type="number" id="rarity" wire:model="rarity" min="1" max="10" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('rarity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        {{-- 攻撃力 --}}
                        <div>
                            <label for="attack" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">攻撃力 <span class="text-red-600">*</span></label>
                            <input type="number" id="attack" wire:model="attack" min="0" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('attack') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        {{-- 防御力ボーナス --}}
                        <div>
                            <label for="defense" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">防御力ボーナス</label>
                            <input type="number" id="defense" wire:model="defense" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('defense') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        {{-- 属性種別 --}}
                        <div>
                            <label for="element_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">属性種別 <span class="text-red-600">*</span></label>
                            <select id="element_type" wire:model="element_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @foreach($elementTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('element_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        {{-- 属性値 --}}
                        <div>
                            <label for="element_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">属性値</label>
                            <input type="number" id="element_value" wire:model="element_value" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('element_value') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        {{-- スロット --}}
                        <div class="col-span-1 md:col-span-2 grid grid-cols-3 gap-4">
                            <div>
                                <label for="slot_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">スロット1</label>
                                <select id="slot_1" wire:model="slot_1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="0">なし</option>
                                    <option value="1">レベル1</option>
                                    <option value="2">レベル2</option>
                                    <option value="3">レベル3</option>
                                </select>
                                @error('slot_1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="slot_2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">スロット2</label>
                                <select id="slot_2" wire:model="slot_2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="0">なし</option>
                                    <option value="1">レベル1</option>
                                    <option value="2">レベル2</option>
                                    <option value="3">レベル3</option>
                                    <option value="4">レベル4</option>
                                </select>
                                @error('slot_2') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="slot_3" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">スロット3</label>
                                <select id="slot_3" wire:model="slot_3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="0">なし</option>
                                    <option value="1">レベル1</option>
                                    <option value="2">レベル2</option>
                                    <option value="3">レベル3</option>
                                    <option value="4">レベル4</option>
                                </select>
                                @error('slot_3') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        {{-- 画像 --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">武器画像</label>
                            <input type="file" id="image" wire:model="image" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            
                            <!-- プレビュー -->
                            @if ($image)
                                <div class="mt-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="プレビュー" class="h-32 object-cover rounded-md">
                                </div>
                            @endif
                        </div>
                        {{-- 強化元 --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="parent_weapon_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">親武器（強化元）</label>
                            <select id="parent_weapon_id" wire:model="parent_weapon_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">なし</option>
                                @foreach($parentWeapons as $parentWeapon)
                                    <option value="{{ $parentWeapon->id }}">{{ $parentWeapon->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                {{-- 通常の切れ味セレクション --}}
                <div class="col-span-1 bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">通常の切れ味</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="normal_red" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">赤ゲージ</label>
                            <input type="number" id="normal_red" wire:model.live.debounce.300ms="normal_red" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('normal_red') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="normal_orange" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">オレンジゲージ</label>
                            <input type="number" id="normal_orange" wire:model.live.debounce.300ms="normal_orange" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('normal_orange') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="normal_yellow" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">黄ゲージ</label>
                            <input type="number" id="normal_yellow" wire:model.live.debounce.300ms="normal_yellow" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('normal_yellow') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="normal_green" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">緑ゲージ</label>
                            <input type="number" id="normal_green" wire:model.live.debounce.300ms="normal_green" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('normal_green') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="normal_blue" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">青ゲージ</label>
                            <input type="number" id="normal_blue" wire:model.live.debounce.300ms="normal_blue" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('normal_blue') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="normal_white" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">白ゲージ</label>
                            <input type="number" id="normal_white" wire:model.live.debounce.300ms="normal_white" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('normal_white') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="normal_purple" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">紫ゲージ</label>
                            <input type="number" id="normal_purple" wire:model.live.debounce.300ms="normal_purple" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('normal_purple') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- 切れ味プレビュー --}}
                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">切れ味プレビュー</h3>
                            <div class="w-full h-6 rounded-md overflow-hidden flex">
                                <div class="h-full bg-red-600" style="width: {{ ($normal_red / 500) * 100 }}%"></div>
                                <div class="h-full bg-orange-500" style="width: {{ ($normal_orange / 500) * 100 }}%"></div>
                                <div class="h-full bg-yellow-500" style="width: {{ ($normal_yellow / 500) * 100 }}%"></div>
                                <div class="h-full bg-green-500" style="width: {{ ($normal_green / 500) * 100 }}%"></div>
                                <div class="h-full bg-blue-500" style="width: {{ ($normal_blue / 500) * 100 }}%"></div>
                                <div class="h-full bg-gray-200" style="width: {{ ($normal_white / 500) * 100 }}%"></div>
                                <div class="h-full bg-purple-600" style="width: {{ ($normal_purple / 500) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- 匠スキル適用時の切れ味セレクション --}}
                <div class="col-span-1 bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">匠スキル適用時の切れ味</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="handicraft_red" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">赤ゲージ</label>
                            <input type="number" id="handicraft_red" wire:model.live="handicraft_red" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('handicraft_red') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="handicraft_orange" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">オレンジゲージ</label>
                            <input type="number" id="handicraft_orange" wire:model.live="handicraft_orange" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('handicraft_orange') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="handicraft_yellow" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">黄ゲージ</label>
                            <input type="number" id="handicraft_yellow" wire:model.live="handicraft_yellow" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('handicraft_yellow') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="handicraft_green" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">緑ゲージ</label>
                            <input type="number" id="handicraft_green" wire:model.live="handicraft_green" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('handicraft_green') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="handicraft_blue" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">青ゲージ</label>
                            <input type="number" id="handicraft_blue" wire:model.live="handicraft_blue" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('handicraft_blue') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="handicraft_white" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">白ゲージ</label>
                            <input type="number" id="handicraft_white" wire:model.live="handicraft_white" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('handicraft_white') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="handicraft_purple" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">紫ゲージ</label>
                            <input type="number" id="handicraft_purple" wire:model.live="handicraft_purple" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('handicraft_purple') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- 切れ味プレビュー --}}
                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">切れ味プレビュー</h3>
                            <div class="w-full h-6 rounded-md overflow-hidden flex">
                                <div class="h-full bg-red-600" style="width: {{ ($handicraft_red / 500) * 100 }}%"></div>
                                <div class="h-full bg-orange-500" style="width: {{ ($handicraft_orange / 500) * 100 }}%"></div>
                                <div class="h-full bg-yellow-500" style="width: {{ ($handicraft_yellow / 500) * 100 }}%"></div>
                                <div class="h-full bg-green-500" style="width: {{ ($handicraft_green / 500) * 100 }}%"></div>
                                <div class="h-full bg-blue-500" style="width: {{ ($handicraft_blue / 500) * 100 }}%"></div>
                                <div class="h-full bg-gray-200" style="width: {{ ($handicraft_white / 500) * 100 }}%"></div>
                                <div class="h-full bg-purple-600" style="width: {{ ($handicraft_purple / 500) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
