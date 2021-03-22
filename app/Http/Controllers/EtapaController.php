<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Candidato;
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
        Gate::authorize('criar-etapa');
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
        
        if ($request->texto != null) {
            $etapa->texto                           = $request->texto;
        } else {
            $etapa->texto                           = "";
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

        if ($request->atual != null) {
            $requestAxu = new Request(['etapa_atual' => $etapa->id]);
            $this->definirEtapa($requestAxu);
        }

        // LEMBRAR DE COLOCAR A CHECAGEM ]
        // Continuar implementação apois mudança de qual dose a pessoa vai tomar
        $candidatos = Candidato::where([['idade', '>=', $etapa->inicio_intervalo], ['idade', '<=', $etapa->fim_intervalo], ['aprovacao', Candidato::APROVACAO_ENUM[3]]])->get();
        if ($candidatos != null && count($candidatos) > 0) {
            foreach ($candidatos as $candidato) {
                if ($candidato->etapa_id == null) {
                    if ($candidato->dose == Candidato::DOSE_ENUM[0]) {
                        $etapa->total_pessoas_vacinadas_pri_dose += 1;
                    } else if ($candidato->dose == Candidato::DOSE_ENUM[1]) {
                        $etapa->total_pessoas_vacinadas_seg_dose += 1;
                    }
                }
            }
            $etapa->update();
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
        // if ($etapa != null) {
        //     $etapa->atual   = false;
        //     $etapa->update();
        // }

        // if ($request != null) {
        //     $etapaAtual         = Etapa::find($request->etapa_atual);
        //     $etapaAtual->atual  = true;
        //     $etapaAtual->update();
        // }

        // return redirect( route('etapas.index') )->with(['mensagem' => 'Etapa atual definida com sucesso!']);
    }
}
