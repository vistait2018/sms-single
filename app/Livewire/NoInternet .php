<?php

namespace App\Livewire\Errors;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class NoInternet extends Component
{
    #[Layout('layouts.app')]
    #[Title('Service Not Available')]
    public function render()
    {
        return view('livewire.errors.no-internet');
    }
}