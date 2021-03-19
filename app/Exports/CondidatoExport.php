<?php

namespace App\Exports;

use App\Models\Candidato;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CondidatoExport implements FromCollection, ShouldAutoSize,WithHeadings
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
            'unidade_caso_agente_de_saude',
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

}
