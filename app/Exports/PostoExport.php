<?php

namespace App\Exports;

use App\Models\PostoVacinacao;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostoExport implements FromCollection, ShouldAutoSize,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PostoVacinacao::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'Nome do ponto',
            'Endereco',
            'Vacinas Disponiveis'
        ];
    }
}
