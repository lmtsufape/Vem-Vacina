<?php

namespace App\Http\Livewire;

use App\Models\Etapa;
use Livewire\Component;
use App\Models\Candidato;

class Contador extends Component
{

    public $publicos;
    public $aprovacao;
    public $contadorPessoas;

    public function mount()
    {

        $this->publicos = Etapa::orderBy('texto')->get();
        $this->aprovacao = Candidato::APROVACAO_ENUM;
        $this->contadorPessoas = 0;

    }

    public function contador()
    {
        $this->publicos = Etapa::orderBy('texto')->get();
        $this->aprovacao = Candidato::APROVACAO_ENUM;
    }

    public function render()
    {
        return view('livewire.contador');
    }
}
