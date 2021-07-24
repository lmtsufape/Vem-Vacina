<?php

namespace App\Http\Controllers;

use App\Models\Dia;
use App\Models\PostoVacinacao;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        // dd( array_values($request->posto) );
        $todosPosto = PostoVacinacao::where('status', '!=', 'arquivado')->orderBy('nome')->get();
        if($request->posto == null){
            $postos = PostoVacinacao::where('status', '!=', 'arquivado')->orderBy('nome')->get();
        }else{
            $postos = PostoVacinacao::where('status', '!=', 'arquivado')->whereIn('id', $request->posto)->orderBy('nome')->get();
        }
        // dd($postos);
        return view('horarios.index', compact('postos', 'todosPosto'));
    }

    public function delete($posto_id, $dia_id)
    {
        $posto = PostoVacinacao::find($posto_id);
        $posto->dias()->where('id', $dia_id)->forceDelete();
        // session(['posto_id' => $request->fullUrl()]);
        return back()->with(['message'=> "Dia apagado do ponto '". $posto->nome. "'!", 'posto_id' => $posto_id]);
    }
}
