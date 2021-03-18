<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Distribuir extends Component
{
    public $lote;
    public $postos;
    public $array_vacinas_disponiveis;
    public $number = ['teste' => 0];

    public function mount()
    {
       $this->atribuicao();
    }

    public function atribuicao()
    {
        foreach($this->postos as $key => $posto){
            $this->array_vacinas_disponiveis[$posto->nome] = $posto->vacinas_disponiveis;
        }
    }

    public function calcular()
    {
        foreach($this->postos as $posto){
            $this->lote->qtdVacina -= $this->array_vacinas_disponiveis[$posto->nome];
        }


    }

    public function render()
    {
        return view('livewire.distribuir');
    }
}
