<?php

namespace App\Livewire;

use Livewire\Component;

class HeaderNavigation extends Component
{
    public $mobileMenuOpen = false;

    protected $listeners = ['toggleMobileMenu'];

    public function toggleMobileMenu()
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }

    public function render()
    {
        return view('livewire.header-navigation');
    }
}
