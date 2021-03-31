<?php

namespace App\Exports;

use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\PostoVacinacao;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PostoCandidatoExport implements ShouldAutoSize,WithHeadings, FromView
{
    public $posto_id;
    public $posto;

    public function __construct($posto_id)
    {
        $this->posto_id = $posto_id;
    }
    public function collection()
    {
        $posto = PostoVacinacao::where('nome', $this->posto_id)->first();
        return $posto->candidatos;
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

        $this->posto = PostoVacinacao::with('candidatos')->where('id', $this->posto_id)->first();
        return view('export.candidatos', [
            'candidatos' => $this->posto->candidatos,
            'tipos' => Etapa::TIPO_ENUM
        ]);
    }

}
