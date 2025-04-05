<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin-app')] class extends Component {
    //
}; ?>

<div>
    <h1>Dashboard</h1>
    <p>Welcome to the admin dashboard.</p>
    {{-- ログアウト --}}
    <button wire:click="logout">Logout</button>
</div>
