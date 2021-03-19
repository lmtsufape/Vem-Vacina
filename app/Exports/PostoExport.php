<?php

namespace App\Exports;

use App\Models\PostoVacinacao;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PostoVacinacao::all();
    }
}
