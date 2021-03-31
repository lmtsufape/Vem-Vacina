<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\PostoVacinacao;
use Carbon\Carbon;

class CandidatosPostoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $posto = null;

    public function __construct(PostoVacinacao $posto) 
    {
        $this->posto = $posto;
    }

    public function collection()
    {
        $hoje = Carbon::now()->format("Y-m-d");
        return $this->posto->candidatos()->where('chegada', 'like', $hoje.'%')->get();
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
            'candidatos' => Candidato::withTrashed()->get(),
            'tipos' => Etapa::TIPO_ENUM
        ]);
    }
}
