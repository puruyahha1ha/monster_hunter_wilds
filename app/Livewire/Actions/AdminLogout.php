<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminLogout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
        Auth::guard('admin')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/admin/login');
    }
}
