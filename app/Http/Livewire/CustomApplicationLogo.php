<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CustomApplicationLogo extends Component
{
    public function render()
    {
        return view('livewire.custom-application-logo',[
            'logo'=> 'images/logo.png',
        ]);
    }
}
