<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('モンスターハンターワイルド 情報サイト - ホーム')]
class Page extends Component
{
    public function render()
    {
        return view('livewire.home.page');
    }
}
