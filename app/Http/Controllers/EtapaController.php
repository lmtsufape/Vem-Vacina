<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\PostoVacinacao;
use App\Models\OpcoesEtapa;
use Illuminate\Support\Facades\Gate;

class EtapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('ver-etapa');
        $etapas = Etapa::where('tipo', '!=', Etapa::TIPO_ENUM[3])->orderBy('id')->get();

        return view('etapas.index')->with(['etapas' => $etapas, 'tipos' => Etapa::TIPO_ENUM]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('criar-etapa');
        $pontos = PostoVacinacao::all();
        return view('etapas.create')->with(['tipos' => Etapa::TIPO_ENUM,
                                            'pontos' => $pontos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('criar-etapa');
        // dd($request);
        $validated = $request->validate([
            'tipo'                => 'required',
            'texto_do_agendamento'=> 'required|max:30',
            'texto_da_home'       => 'required|max:30',
            'inicio_faixa_etária' => 'required_if:tipo,'.Etapa::TIPO_ENUM[0].'|min:0|max:110',
            'fim_faixa_etária'    => 'required_if:tipo,'.Etapa::TIPO_ENUM[0].'|min:'.$request->inicio_faixa_etaria.'|max:150',
            'opcoes'              => 'required_if:tipo,'.Etapa::TIPO_ENUM[2],
            'opcoes.*'            => 'required_if:tipo,'.Etapa::TIPO_ENUM[2].'|max:40',
            'exibir_na_home'      => 'nullable',
            'exibir_no_form'      => 'nullable',    
            'atual'               => 'nullable',
            'primeria_dose'       => 'nullable|min:0',
            'segunda_dose'        => 'nullable|min:0',
            'pontos'              => 'required',
        ]);

        // dd("passou");
        $etapa = new Etapa();
        $etapa->tipo = $request->tipo;
        $etapa->texto = $request->texto_do_agendamento;
        $etapa->texto_home = $request->texto_da_home;

        if ($request->atual != null) {
            $etapa->atual = true;
        } else {
            $etapa->atual = false;
        }

        if ($request->exibir_no_form != null) {
            $etapa->exibir_no_form = true;
        } else {
            $etapa->exibir_no_form = false;
        }

        if ($request->exibir_na_home != null) {
            $etapa->exibir_na_home = true;
        } else {
            $etapa->exibir_na_home = false;
        }

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

        if ($request->tipo == Etapa::TIPO_ENUM[0]) {
            $etapa->inicio_intervalo = $request->input("inicio_faixa_etária");
            $etapa->fim_intervalo = $request->input("fim_faixa_etária");
            $etapa->update();
        } else if ($request->tipo == Etapa::TIPO_ENUM[2]) {
            foreach ($request->opcoes as $op) {
                $opcaoEtapa = new OpcoesEtapa();
                $opcaoEtapa->opcao = $op;
                $opcaoEtapa->etapa_id = $etapa->id;
                $opcaoEtapa->save();
            }
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
        Gate::authorize('editar-etapa');
        $validated = $request->validate([
            'etapa_id'            => 'required',
            'inicio_faixa_etaria' => 'required|integer|min:0|max:110',
            'fim_faixa_etaria'    => 'required|integer|min:'.$request->inicio_faixa_etaria.'|max:150',
            'texto'               => 'nullable',
            'primeria_dose'       => 'nullable',
            'segunda_dose'        => 'nullable',
        ]);

        $etapa = Etapa::find($id);
        $etapa->inicio_intervalo                    = $request->inicio_faixa_etaria;
        $etapa->fim_intervalo                       = $request->fim_faixa_etaria;
        if ($request->texto != null) {
            $etapa->texto                           = $request->texto;
        } else {
            $etapa->texto                           = "";
        }
        $etapa->total_pessoas_vacinadas_pri_dose    = $request->primeria_dose;
        $etapa->total_pessoas_vacinadas_seg_dose    = $request->segunda_dose;
        $etapa->update();

        return redirect( route('etapas.index') )->with(['mensagem' => 'Etapa salva com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('apagar-etapa');
        $etapa = Etapa::find($id);
        $candidatos = $etapa->candidatos;
        if ($candidatos != null && count($candidatos) > 0) {
            foreach ($candidatos as $candidato) {
                $candidato->etapa_id = null;
                $candidato->update();
            }
        }

        $etapa->delete();

        return redirect( route('etapas.index') )->with(['mensagem' => 'Etapa excluida com sucesso!']);
    }

    public function definirEtapa(Request $request)
    {
        Gate::authorize('definir-etapa');
        $etapa          = Etapa::find($request->etapa_id);
        $etapa->atual   = $request->valor;
        $etapa->update();

        if ($request->intero) {
            return;
        } else {
            return abort(200);
        }
    }
}
