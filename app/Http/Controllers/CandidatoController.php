<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;

class CandidatoController extends Controller
{
    public function show() {
        $candidatos = Candidato::all();

        return view('dashboard')->with(['candidatos' => $candidatos]);
    }
}
