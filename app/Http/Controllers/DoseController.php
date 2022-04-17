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

    public function registrar(Request $request)
    {
        Gate::authorize('criar-dose');
        $validatedData = $request->validate([
            'nome' => ['required', 'string']
        ]);
        $dose = Dose::create([
            'nome' => $request->nome,
            'dose_anterior_id' => $request->dose_anterior
        ]);
        $dose->save();
        $dose->etapas()->sync($request->etapa_id);


        Gate::authorize('ver-dose');
        $doses = Dose::all();

        return redirect()->route('doses.index')->with(['sucesso' => $dose->nome.' registrada com sucesso', 'doses' => $doses]);
    }

    public function edit($id)
    {
        Gate::authorize('editar-dose');

        $dose = Dose::findOrFail($id);
        $tipos = Etapa::TIPO_ENUM;
        $etapas = Etapa::all();
        $doses = Dose::all();
        return view('doses.edit', compact('dose', 'tipos', 'etapas','doses'));
    }

    public function atualizar(Request $request, $id){
        Gate::authorize('editar-dose');
        $validatedData = $request->validate([
            'nome' => ['required', 'string']
        ]);
        $dose = Dose::find($id);
        $dose->nome = $request->nome;
        $dose->dose_anterior_id = $request->dose_anterior;
        $dose->update();
        $dose->etapas()->sync($request->etapa_id);

        Gate::authorize('ver-dose');
        $doses = Dose::all();

        return redirect()->route('doses.index')->with(['sucesso' => $dose->nome.' atualizada com sucesso', 'doses' => $doses]);
    }

}
