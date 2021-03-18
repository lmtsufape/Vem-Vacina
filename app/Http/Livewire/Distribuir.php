<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Distribuir extends Component
{
    public $lote;
    public $postos;

    public function render()
    {
        return view('livewire.distribuir');
    }
}
