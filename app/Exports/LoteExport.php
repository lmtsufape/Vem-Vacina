<?php

namespace App\Exports;

use App\Models\Lote;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoteExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lote::all();
    }
}
