<?php

namespace App\Livewire\Home;

use Livewire\Component;

class QuickLinksSection extends Component
{
    public $quickLinks = [
        [
            'label' => '武器データベース',
            'url' => '/weapons',
        ],
        [
            'label' => '防具データベース',
            'url' => '/armors',
        ],
        [
            'label' => 'モンスター図鑑',
            'url' => '/monsters',
        ],
        [
            'label' => 'アイテム一覧',
            'url' => '/items',
        ],
        [
            'label' => 'マップ情報',
            'url' => '/maps',
        ],
        [
            'label' => 'コミュニティ',
            'url' => '/community',
        ]
    ];

    public function render()
    {
        return view('livewire.home.quick-links-section');
    }
}
