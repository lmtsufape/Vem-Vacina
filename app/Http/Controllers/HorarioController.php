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
        $todosPosto = PostoVacinacao::all();
        if($request->posto == null){
            $postos = PostoVacinacao::all();
        }else{
            $postos = PostoVacinacao::whereIn('id', $request->posto)->get();
        }
        // dd($postos);
        return view('horarios.index', compact('postos', 'todosPosto'));
    }
}
