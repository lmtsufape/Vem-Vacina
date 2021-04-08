<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\PostoVacinacao;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
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


}
