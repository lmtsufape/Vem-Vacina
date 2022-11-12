<?php

namespace App\Http\Controllers;

use App\Models\Dose;
use Carbon\Carbon;
use App\Models\Etapa;
use App\Models\Candidato;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use Illuminate\Support\Facades\Auth;

class EstatisticaController extends Controller
{
    public function index(Request $request) {
        // $etapas = Etapa::orderBy('texto')->get();
        $todosPublicos = Etapa::orderBy('texto')->get();
        $doses = Dose::all();
        if($request->publicos == null){
            $etapas = Etapa::orderBy('texto')->get();
        }else{
            $etapas = Etapa::whereIn('id', $request->publicos)->orderBy('texto')->get();
        }
        return view('estatistica.index')->with(['publicos' => $etapas, 'aprovacao' => Candidato::APROVACAO_ENUM, 'todosPublicos' =>$todosPublicos, 'doses'=>$doses]);
    }

    public function showStats(Request $request)
    {
        $todosPublicos = Etapa::orderBy('texto')->get();

        if(Auth::user()->pontos->count() == 0){
            return back()->with(['mensagem' => "Usuário sem Ponto associado"]);
        }
        $ponto = Auth::user()->pontos->first();


        $publicos = Etapa::orderBy('texto_home')->get();
        if ($request->publico_check) {
            $publico_id = $request->publico;
            if ($request->publico != null) {
                $publicos = Etapa::whereIn('id', $request->publico)->orderBy('texto_home')->get();
            }
        }



        return view('estatistica.show_stats')->with(['candidato_enum' => Candidato::APROVACAO_ENUM,
                                        'tipos' => Etapa::TIPO_ENUM,
                                        'postos' => PostoVacinacao::where('status', '!=', 'arquivado')->get(),
                                        'doses' => Candidato::DOSE_ENUM,
                                        'publicos' => $publicos,
                                        'todosPublicos' =>$todosPublicos,
                                        'ponto' =>$ponto,
                                        'request' => $request]);
    }
}
