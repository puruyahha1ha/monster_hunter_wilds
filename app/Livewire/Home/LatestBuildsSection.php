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
    public $perPage = 6;

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
            return Build::with(['user', 'weapon', 'tags'])
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
                'name' => "極・{$weaponType}マスターの装備",
                'image_path' => 'images/build-placeholder.jpg',
                'likes_count' => $likes,
                'created_at' => now()->subDays(rand(1, 10)),
                'weapon_type' => $weaponType,
                'weapon_icon' => 'images/weapon-placeholder.png',
                'tags' => ['高火力', '生存特化'],
                'user' => (object)[
                    'name' => "ハンター{$i}",
                    'profile_image' => 'images/default-avatar.png'
                ]
            ];
        }

        return collect($builds);
    }
}
