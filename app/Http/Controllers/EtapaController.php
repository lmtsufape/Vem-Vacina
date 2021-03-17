<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;

class EtapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etapas = Etapa::orderBy('inicio_intervalo')->get();

        return view('etapas.index')->with(['etapas' => $etapas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('etapas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inicio_faixa_etaria' => 'required|integer|min:0|max:110',
            'fim_faixa_etaria'    => 'required|integer|min:'.$request->inicio_faixa_etaria.'|max:150',
            'atual'               => 'nullable',
            'primeria_dose'       => 'nullable',
            'segunda_dose'        => 'nullable',
        ]);

        $etapa = new Etapa();
        $etapa->inicio_intervalo = $request->inicio_faixa_etaria;
        $etapa->fim_intervalo = $request->fim_faixa_etaria;
        $etapa->atual = false;

        if ($request->primeria_dose != null) {
            $etapa->total_pessoas_vacinadas_pri_dose = $request->primeria_dose;
        } else {
            $etapa->total_pessoas_vacinadas_pri_dose = 0;
        }

        if ($request->segunda_dose != null) {
            $etapa->total_pessoas_vacinadas_seg_dose = $request->segunda_dose;
        } else {
            $etapa->total_pessoas_vacinadas_seg_dose = 0;
        }
        
        $etapa->save();
        
        if ($request->atual != null) {
            $requestAxu = new Request(['etapa_atual' => $etapa->id]);
            $this->definirEtapa($requestAxu);
        } 

        return redirect( route('etapas.index') )->with(['mensagem' => 'Etapa adicionada com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function definirEtapa(Request $request) {
        $etapa          = Etapa::where('atual', true)->first();

        if ($etapa != null) {
            $etapa->atual   = false;
            $etapa->update();
        }

        if ($request != null) {
            $etapaAtual         = Etapa::find($request->etapa_atual);
            $etapaAtual->atual  = true;
            $etapaAtual->update();
        }
        
        return redirect( route('etapas.index') )->with(['mensagem' => 'Etapa atual definida com sucesso!']);
    }
}
