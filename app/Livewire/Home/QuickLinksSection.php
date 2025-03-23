<?php

namespace App\Livewire\Home;

use Livewire\Component;

class QuickLinksSection extends Component
{
    public $quickLinks = [
        ['ラベル' => '武器データベース'],
        ['ラベル' => '防具データベース'],
        ['ラベル' => 'モンスター図鑑'],
        ['ラベル' => 'アイテム一覧'],
        ['ラベル' => 'マップ情報'],
        ['ラベル' => 'コミュニティ']
    ];

    public function render()
    {
        return view('livewire.home.quick-links-section');
    }
}
