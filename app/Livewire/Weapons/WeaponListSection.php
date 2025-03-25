<?php

namespace App\Livewire\Weapons;

use App\Models\Weapon;
use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\WithPagination;

/**
 * 遅延ロードを適用した武器一覧セクション
 */
#[Lazy]
class WeaponListSection extends Component
{
    use WithPagination;

    public Weapon $weapons;
    /**
     * 現在のページ番号
     */
    public $page = 1;

    /**
     * 現在選択されている武器タイプ
     */
    public $selectedWeaponType = 'all';

    /**
     * 武器タイプリスト
     */
    public $weaponTypes = [
        'all' => 'すべての武器',
        '大剣' => '大剣',
        '片手剣' => '片手剣',
        '双剣' => '双剣',
        'ハンマー' => 'ハンマー',
        'ランス' => 'ランス',
        'ガンランス' => 'ガンランス',
        '操虫棍' => '操虫棍',
        '狩猟笛' => '狩猟笛',
        'スラッシュアックス' => 'スラッシュアックス',
        'チャージアックス' => 'チャージアックス',
        'ライトボウガン' => 'ライトボウガン',
        'ヘビィボウガン' => 'ヘビィボウガン',
        '弓' => '弓',
    ];

    /**
     * ソート順
     */
    public $sortField = 'name';
    public $sortDirection = 'asc';

    /**
     * 検索キーワード
     */
    public $search = '';

    /**
     * ロード中状態
     */
    public $loading = false;

    /**
     * 一度に表示するアイテム数
     */
    public $perPage = 15;

    /**
     * カスタムページ変更リスナー
     */
    /**
     * ページ番号を設定
     */
    public function setPage($page)
    {
        $this->page = $page;
        $this->loading = true;
        $this->loading = false;
    }

    /**
     * ページ変更時
     */
    public function updatedPage()
    {
        $this->loading = true;
        $this->loading = false;
    }

    /**
     * 武器タイプフィルター変更時
     */
    public function updatedSelectedWeaponType()
    {
        $this->resetPage();
        $this->loading = true;
        $this->loading = false;
    }

    /**
     * 検索キーワード変更時
     */
    public function updatedSearch()
    {
        $this->resetPage();
        $this->loading = true;
        $this->loading = false;
    }

    /**
     * ソート順変更
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->loading = true;
        $this->loading = false;
    }

    /**
     * プレースホルダーコンポーネント
     */
    public function placeholder()
    {
        return view('placeholders.weapons-list-section');
    }

    /**
     * 武器一覧を取得
     */
    public function getWeapons()
    {
        // キャッシュキー生成（フィルターとページに基づく）
        $cacheKey = "weapons_{$this->selectedWeaponType}_{$this->search}_{$this->sortField}_{$this->sortDirection}_{$this->page}";

        // 実際のデータベースクエリの代わりにサンプルデータを使用
        // 本番環境では次のように実装する
        return cache()->remember($cacheKey, now()->addMinutes(30), function () {
            $query = Weapon::query();
            
            if ($this->selectedWeaponType !== 'all') {
                $query->where('weapon_type', $this->selectedWeaponType);
            }
            
            if (!empty($this->search)) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('special_ability', 'like', "%{$this->search}%");
                });
            }
            
            return $query->orderBy($this->sortField, $this->sortDirection)
                         ->paginate($this->perPage);
        });
    }

    /**
     * サンプル武器データを生成（本来はDBから取得）
     */
    private function getSampleWeapons()
    {
        $weaponTypes = array_keys(array_filter($this->weaponTypes, function ($key) {
            return $key !== 'all';
        }, ARRAY_FILTER_USE_KEY));

        $elementTypes = ['火', '水', '雷', '氷', '龍', 'なし'];
        $rarities = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $this->weapons = collect();

        for ($i = 1; $i <= 100; $i++) {
            $weaponType = $weaponTypes[array_rand($weaponTypes)];
            $elementType = $elementTypes[array_rand($elementTypes)];
            $rarity = $rarities[array_rand($rarities)];
            $attack = rand(100, 1500);
            $affinity = rand(-30, 40);

            // フィルター条件に合致するかチェック
            if ($this->selectedWeaponType !== 'all' && $weaponType !== $this->selectedWeaponType) {
                continue;
            }

            $name = $this->getWeaponName($weaponType, $rarity);

            if (!empty($this->search) && stripos($name, $this->search) === false) {
                continue;
            }

            $this->weapons[] = (object)[
                'id' => $i,
                'name' => $name,
                'weapon_type' => $weaponType,
                'rarity' => $rarity,
                'attack' => $attack,
                'element_type' => $elementType,
                'element_value' => $elementType !== 'なし' ? rand(100, 500) : 0,
                'affinity' => $affinity,
                'slot_1' => rand(0, 4),
                'slot_2' => rand(0, 3),
                'slot_3' => rand(0, 2),
                'special_ability' => '会心率強化',
                'image_path' => '/images/weapons/' . strtolower(str_replace(' ', '-', $weaponType)) . '.png',
            ];
        }

        // ソート処理
        usort($this->weapons, function ($a, $b) {
            if ($this->sortDirection === 'asc') {
                return $a->{$this->sortField} <=> $b->{$this->sortField};
            } else {
                return $b->{$this->sortField} <=> $a->{$this->sortField};
            }
        });

        // ページネーション用にスライス
        $total = count($this->weapons);
        $page = $this->page ?? 1;
        $start = ($page - 1) * $this->perPage;
        $sliced = array_slice($this->weapons, $start, $this->perPage);

        $result = new \stdClass();
        $result->data = $sliced;
        $result->total = $total;
        $result->perPage = $this->perPage;
        $result->currentPage = $page;
        $result->lastPage = ceil($total / $this->perPage);


        return $result;
    }

    /**
     * 武器名を生成
     */
    private function getWeaponName($type, $rarity)
    {
        $prefixes = ['王牙', '蒼炎', '雷神', '冥灯', '鋼鉄', '黒鎧', '竜骨', '氷霜', '紅蓮', '翠風', '月光', '凶星', '覇王'];
        $suffixes = ['【滅尽】', '【閃光】', '【業火】', '【氷刃】', '【轟雷】', '【断罪】', '【神髄】', '【極】', '【真】', '【魂】'];

        $prefix = $prefixes[array_rand($prefixes)];
        $suffix = $rarity > 5 ? $suffixes[array_rand($suffixes)] : '';

        return $prefix . $type . $suffix;
    }

    /**
     * レンダリング
     */
    public function render()
    {
        $this->weapons = $this->getWeapons();

        return view('livewire.weapons.weapon-list-section');
    }
}
