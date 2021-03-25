<?php

namespace App\Exports;

use App\Models\Lote;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoteExport implements FromCollection,  ShouldAutoSize,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lote::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'Nº do lote',
            'Fabricante',
            'Nº de vacinas',
            'Dose única',
            'Data de fabricação',
            'Data de validade',
        ];
    }
}
