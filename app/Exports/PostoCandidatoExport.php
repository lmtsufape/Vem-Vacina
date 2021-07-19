<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\PostoVacinacao;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PostoCandidatoExport implements ShouldAutoSize,WithHeadings, FromView
{

    public $posto;
    public $candidatos;

    public function __construct($candidatos)
    {

        $this->candidatos = $candidatos;
    }


    public function headings(): array
    {
        return [
            '#',
            'nome_completo',
            'data_de_nascimento',
            'idade',
            'cpf',
            'numero_cartao_sus',
            'sexo',
            'nome_da_mae',
            'paciente_acamado',
            'telefone',
            'whatsapp',
            'email',
            'cep',
            'cidade',
            'bairro',
            'numero_residencia',
            'complemento_endereco',
            'aprovacao',
            'chegada',
            'saida',
        ];
    }

    public function view(): View
    {

        return view('export.candidatos', [
            'candidatos' => $this->candidatos,
            'tipos' => Etapa::TIPO_ENUM
        ]);
    }

}
