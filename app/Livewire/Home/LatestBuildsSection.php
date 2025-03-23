<?php

namespace App\Livewire\Home;

use App\Models\Build;
use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\WithPagination;

/**
 * 遅延ロードを適用したセクションコンポーネント
 */
#[Lazy]
class LatestBuildsSection extends Component
{
    use WithPagination;

    /**
     * 一度に表示するアイテム数
     */
    public $perPage = 3;

    /**
     * ロード中状態
     */
    public $loading = false;

    /**
     * コンポーネントがマウントされたときに実行
     * ベストプラクティス: 初期データローディングはmountに集中させる
     */
    public function mount()
    {
        // 非同期ロードの初期化コードがあれば記述
    }

    /**
     * もっと見るボタンクリック時のアクション
     * ベストプラクティス: 明確なメソッド名とシンプルな責務
     */
    public function loadMore()
    {
        $this->loading = true;

        // ページネーションではなく、表示数を増やす方式
        $this->perPage += 3;

        // UIの更新のために少し遅延
        usleep(300000); // 300ms

        $this->loading = false;
    }

    /**
     * 新着装備データ取得
     * キャッシュ最適化も考慮
     */
    public function getLatestBuilds()
    {
        // キャッシュキー名を生成（ページ数に応じて変化）
        $cacheKey = "latest_builds_{$this->perPage}";

        // ベストプラクティス: パフォーマンス向上のためのキャッシュ
        return cache()->remember($cacheKey, now()->addMinutes(30), function () {
            return Build::with([
                'user',
                'tags',
                'likes',
                'detail.weapon',
                'detail.headArmor',
                'detail.chestArmor',
                'detail.armArmor',
                'detail.waistArmor',
                'detail.legArmor',
                'detail.mantle1',
                'detail.mantle2',
                'skills'
            ])
                ->latest()
                ->take($this->perPage)
                ->get();
        });
    }

    /**
     * レンダリング
     */
    public function render()
    {
        // サンプルデータを使用（本番環境ではDBから取得）
        $latestBuilds = $this->getSampleBuilds($this->perPage);

        // $latestBuilds = $this->getLatestBuilds();

        return view('livewire.home.latest-builds-section', [
            'latestBuilds' => $latestBuilds,
            'hasMoreBuilds' => count($latestBuilds) >= $this->perPage // もっと表示ボタンの表示制御
        ]);
    }

    /**
     * サンプルの装備セットデータを生成（本来はDBから取得）
     */
    private function getSampleBuilds($count)
    {
        $builds = [];
        $weaponTypes = ['大剣', '片手剣', '双剣', 'ハンマー', 'ランス', 'ライトボウガン', 'ヘビィボウガン', '操虫棍', '狩猟笛'];

        for ($i = 1; $i <= $count; $i++) {
            $weaponType = $weaponTypes[array_rand($weaponTypes)];
            $likes = rand(5, 120);

            $builds[] = (object)[
                'id' => $i,
                'title' => "極・{$weaponType}マスターの装備",
                'description' => 'この装備は、モンスターを狩るための最強の装備です。',
                'purpose' => 'モンスター狩り',
                'target_monster' => 'ナルガクルガ',
                'created_at' => now()->subDays(rand(1, 10)),
                'tags' => [
                    (object)['name' => '上位', 'id' => '1'],
                    (object)['name' => '下位', 'id' => '2'],
                    (object)['name' => 'ソロ', 'id' => '3'],
                    (object)['name' => 'マルチ', 'id' => '4'],
                ],
                'user' => (object)[
                    'name' => "ハンター{$i}",
                    'avatar' => ''
                ],
                'likes' => (object)[
                    'count' => $likes,
                ],
                'detail' => (object)[
                    'weapon' => (object)['name' => $weaponType],
                    'head_armor' => (object)['name' => 'オーグヘルム'],
                    'chest_armor' => (object)['name' => 'オーグメイル'],
                    'arm_armor' => (object)['name' => 'オーグアーム'],
                    'waist_armor' => (object)['name' => 'オーグコイル'],
                    'leg_armor' => (object)['name' => 'オーググリーヴ'],
                    'mantle1' => (object)['name' => '攻撃のマント'],
                    'mantle2' => (object)['name' => '耐震のマント'],
                ],
                'skills' => [
                    (object)['skill_id' => '1', 'level' => 7, 'skill' => (object)['name' => '攻撃力UP', 'description' => '攻撃力が上昇する']],
                    (object)['skill_id' => '2', 'level' => 5, 'skill' => (object)['name' => '会心率UP', 'description' => '会心率が上昇する']],
                    (object)['skill_id' => '3', 'level' => 3, 'skill' => (object)['name' => 'スタミナUP', 'description' => 'スタミナが上昇する']],
                ]
            ];
        }

        return collect($builds);
    }
}
