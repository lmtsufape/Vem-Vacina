<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
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
        //dd($request->exibir_home);
        Gate::authorize('criar-dose');
        $validatedData = $request->validate([
            'nome' => ['required', 'string']
        ]);
        if(!isset($request->exibir_home))
            $request->exibir_home = false;

        if(!isset($request->desabilitar_cpf))
            $request->desabilitar_cpf = false;

        $dose = Dose::create([
            'nome' => $request->nome,
            'dose_anterior_id' => $request->dose_anterior,
            'exibir_home' => $request->exibir_home,
            'desabilitar_cpf' => $request->desabilitar_cpf
        ]);
        $dose->intervalo = $request->intervalo;
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

        if(!isset($request->exibir_home))
            $request->exibir_home = false;

        if(!isset($request->desabilitar_cpf))
            $request->desabilitar_cpf = false;

        $dose->exibir_home = $request->exibir_home;
        $dose->desabilitar_cpf = $request->desabilitar_cpf;
        $dose->intervalo = $request->intervalo;
        $dose->update();
        $dose->etapas()->sync($request->etapa_id);

        Gate::authorize('ver-dose');
        $doses = Dose::all();

        return redirect()->route('doses.index')->with(['sucesso' => $dose->nome.' atualizada com sucesso', 'doses' => $doses]);
    }

    public function destroy($id)
    {
        Gate::authorize('apagar-dose');
        $dose = Dose::findOrFail($id);
        //Verificar se existem doses associadas
        $dosesAssociadas = Dose::where('dose_anterior_id',$dose->id)->get();

        if($dosesAssociadas->count()){
            return redirect()->back()
                ->withErrors([
                    "message" => "Existem doses associadas com a ".$dose->nome."."
                ])->withInput();
        }
        //Verificar se existem candidatos associados
        $candidatosAssociados = Candidato::where('dose_id',$dose->id)->get();
        if($candidatosAssociados->count()){
            return redirect()->back()
                ->withErrors([
                    "message" => "Existem candidatos associados com a ".$dose->nome."."
                ])->withInput();
        }

        $nome =  $dose->nome;
        $dose->etapas()->sync([]);
        $dose->delete();
        Gate::authorize('ver-dose');
        $doses = Dose::all();

        return redirect()->route('doses.index')->with(['sucesso' => $nome.' deletada com sucesso', 'doses' => $doses]);
    }

}
