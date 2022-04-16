<?php

namespace App\Http\Controllers;

use App\Models\Dose;
use App\Models\Etapa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DoseController extends Controller
{

    public function index()
    {
        Gate::authorize('ver-dose');
        $doses = Dose::all();
        return view('doses.index', compact('doses'));
    }

    public function create()
    {
        Gate::authorize('criar-dose');
        $doses = Dose::all();
        $etapas = Etapa::where('tipo', '!=', Etapa::TIPO_ENUM[3])->orderBy('id')->get();
        return view('doses.create')->with(['etapas' => $etapas,
            'tipos' => Etapa::TIPO_ENUM, 'doses' => $doses]);
    }

    public function registrar(Request $request){
        Gate::authorize('criar-dose');
        $validatedData = $request->validate([
            'nome'  => ['required', 'string']
        ]);
        $dose = Dose::create([
            'nome' => $request->nome,
            'dose_anterior' => $request->dose_anterior
        ]);
        $dose->save();
        $dose->etapas()->sync($request->etapa_id);


        Gate::authorize('ver-dose');
        $doses = Dose::all();

        return redirect()->route('doses.index')->with(['sucesso' => 'Dose registrada com sucesso', 'doses' => $doses]);
    }

}
