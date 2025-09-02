<?php

namespace App\Livewire\Fragment;

use Livewire\Component;
use App\Livewire\Actions\Logout as LogoutAction;

class Nav extends Component
{

    public function logout(LogoutAction $logout)
    {
        $logout(); // calls __invoke() from your Logout action
        return redirect()->route('login'); // or wherever you want
    }

    public function render()
    {
        return view('livewire.fragment.nav');
    }
}
