<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Candidato;

class EstatisticaController extends Controller
{
    public function index() {
        $etapas = Etapa::orderBy('texto')->get();
        return view('estatistica.index')->with(['publicos' => $etapas, 'aprovacao' => Candidato::APROVACAO_ENUM]);
    }
}
