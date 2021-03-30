<?php

namespace App\Exports;

use App\Models\Etapa;
use App\Models\Candidato;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CandidatoExport implements ShouldAutoSize,WithHeadings, FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Candidato::all();
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
