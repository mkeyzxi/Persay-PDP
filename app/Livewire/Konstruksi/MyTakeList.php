<?php

namespace App\Livewire\Konstruksi;

use Livewire\Component;

class MyTakeList extends Component
{
    public $spk_number;
    public $wbs_number;

    public function render()
    {
        return view('livewire.konstruksi.my-take-list');
    }
}
