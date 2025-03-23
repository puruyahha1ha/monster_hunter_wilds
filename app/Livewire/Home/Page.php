<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('モンスターハンターワイルド 情報サイト - ホーム')]
class Page extends Component
{
    /**
     * メインのホームページレンダリング
     * 
     * ベストプラクティス:
     * - 親コンポーネントはロジックを最小限に保ち、主に子コンポーネントの組織化に専念
     * - SEO対策としてタイトルを属性で管理
     */
    public function render()
    {
        return view('livewire.home.page');
    }
}
