<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Candidato;

class EditarCandidato extends Component
{

    public $candidato;
    public $candidato_id;
    public $nome_completo;
    public $data_de_nascimento;
    public $cpf;
    public $sexo;
    public $numero_cartao_sus;
    public $nome_da_mae;

    public function mount()
    {
        $candidato = Candidato::find($this->candidato_id);
        $this->data_de_nascimento   = $candidato->data_de_nascimento;
        $this->numero_cartao_sus    = $candidato->numero_cartao_sus;
        $this->nome_completo        = $candidato->nome_completo;
        $this->nome_da_mae          = $candidato->nome_da_mae;
        $this->cpf                  = $candidato->cpf;
        $this->sexo                 = $candidato->sexo;

    }



    protected $rules = [
        "data_de_nascimento"    => "required|date|before:today",
        "numero_cartao_sus"     => "required",
        "nome_completo"         => "required|string|min:8|max:65|regex:/^[\pL\s]+$/u",
        "nome_da_mae"           => "required|string|min:8|max:65|regex:/^[\pL\s]+$/u",
        "cpf"                   => "required",
    ];
    protected $messages = [
        'data_de_nascimento.required' => 'Campo obrigatório.',
        'numero_cartao_sus.required'  => 'Campo obrigatório.',
        'nome_completo.required'      => 'Campo obrigatório.',
        'nome_da_mae.required'        => 'Campo obrigatório.',
        'cpf.required'                => 'Campo obrigatório.',
    ];

    public function updateCandidato()
    {

        $this->validate();

        // dd($this->nome_completo);

        if (Candidato::where('cpf',$this->cpf)->where('id', '!=',$this->candidato_id)->where('aprovacao','!=', Candidato::APROVACAO_ENUM[2])->count() > 1) {
            $this->addError('cpf', 'Já existe um cpf no sistema.');
        }
        $candidato = Candidato::find($this->candidato_id);
        Candidato::where('cpf', $this->cpf)->update([
            'nome_completo'         => $this->nome_completo,
            'cpf'                   => $this->cpf,
            'data_de_nascimento'    => $this->data_de_nascimento,
            'numero_cartao_sus'     => $this->numero_cartao_sus,
            'nome_da_mae'           => $this->nome_da_mae,
        ]);
        session()->flash('mensagem', $this->nome_completo);
        return;


    }

    public function render()
    {
        return view('livewire.editar-candidato');
    }
}
