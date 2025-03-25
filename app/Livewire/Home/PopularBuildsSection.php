<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class PopularBuildsSection extends Component
{

    public function placeholder()
    {
        return view('placeholders.popular-builds-section');
    }

    public function render()
    {
        return view('livewire.home.popular-builds-section');
    }
}
