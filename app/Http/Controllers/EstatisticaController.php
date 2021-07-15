<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Candidato;

class EstatisticaController extends Controller
{
    public function index(Request $request) {
        // $etapas = Etapa::orderBy('texto')->get();
        $todosPublicos = Etapa::orderBy('texto')->get();
        if($request->publicos == null){
            $etapas = Etapa::orderBy('texto')->get();
        }else{
            $etapas = Etapa::whereIn('id', $request->publicos)->orderBy('texto')->get();
        }
        return view('estatistica.index')->with(['publicos' => $etapas, 'aprovacao' => Candidato::APROVACAO_ENUM, 'todosPublicos' =>$todosPublicos]);
    }
}
