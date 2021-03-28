<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\PostoVacinacao;
use App\Models\OpcoesEtapa;
use App\Models\OutrasInfoEtapa;
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
        $pontos = PostoVacinacao::all();
        return view('etapas.index')->with(['etapas' => $etapas, 
                                           'tipos' => Etapa::TIPO_ENUM,]);
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
            'opcoes.*'            => 'required_if:tipo,'.Etapa::TIPO_ENUM[2].'|max:150',
            'exibir_na_home'      => 'nullable',
            'exibir_no_form'      => 'nullable',    
            'atual'               => 'nullable',
            'primeria_dose'       => 'nullable|min:0',
            'segunda_unica'       => 'nullable|min:0',
            'pontos'              => 'required',
            'outras_informações'  => 'nullable',
            'texto_das_outras_informações' => 'nullable',
            'outrasInfo'          => 'required_if:outras_informações,on',
            'outrasInfo.*'        => 'required_if:outras_informações,on',
        ]);
        
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

        if ($request->pontos != null) {
            foreach ($request->pontos as $ponto) {
                $etapa->pontos()->attach($ponto);
            }
        }
        
        if ($request->outras_informações != null) {
            $etapa->texto_outras_informacoes = $request->texto_das_outras_informações;

            if ($request->outrasInfo != null) {
                foreach ($request->outrasInfo as $outraInfo) {
                    $outra = new OutrasInfoEtapa();
                    $outra->campo = $outraInfo;
                    $outra->etapa_id = $etapa->id;
                    $outra->save();
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
        $publico = Etapa::find($id);
        $pontos = PostoVacinacao::all();
        return view('etapas.edit')->with(['publico' => $publico,
                                          'tipos' => Etapa::TIPO_ENUM,
                                          'pontos' => $pontos]);
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
            'tipo'                => 'required',
            'texto_do_agendamento'=> 'required|max:30',
            'texto_da_home'       => 'required|max:30',
            'inicio_faixa_etária' => 'required_if:tipo,'.Etapa::TIPO_ENUM[0].'|min:0|max:110',
            'fim_faixa_etária'    => 'required_if:tipo,'.Etapa::TIPO_ENUM[0].'|min:'.$request->inicio_faixa_etaria.'|max:150',
            'opcoes'              => 'required_if:tipo,'.Etapa::TIPO_ENUM[2],
            'opcoes.*'            => 'required_if:tipo,'.Etapa::TIPO_ENUM[2].'|max:150',
            'exibir_na_home'      => 'nullable',
            'exibir_no_form'      => 'nullable',    
            'atual'               => 'nullable',
            'primeria_dose'       => 'nullable|min:0',
            'segunda_unica'       => 'nullable|min:0',
            'pontos'              => 'required',
            'texto_das_outras_informações' => 'nullable',
            'outrasInfo'          => 'required_if:outras_informações,on',
            'outrasInfo.*'        => 'required_if:outras_informações,on',
        ]);

        $etapa = Etapa::find($id);

        if ($request->tipo == Etapa::TIPO_ENUM[2] && $request->input('opcoes') != null && $request->input('op_ids') != null) {
            $requestOpcoes = collect($request->input('op_ids'));
            $opcaoEtapa = $etapa->opcoes;
            foreach ($opcaoEtapa as $op) {
                if (!($requestOpcoes->contains($op->id))) {
                    if ($op->candidatos != null && count($op->candidatos) > 0) {
                        return redirect()->back()->with([
                            "error" => "Não é possivel excluir a opção " . $op->opcao . " pois exitem agendamentos que a selecionaram.",
                        ]);
                    }
                } 
            }
        } else if (($request->tipo == Etapa::TIPO_ENUM[1] && $etapa->tipo == Etapa::TIPO_ENUM[2]) || ($request->tipo == Etapa::TIPO_ENUM[0] && $etapa->tipo == Etapa::TIPO_ENUM[2])) {
            $candidatos = $etapa->candidatos;
            if ($candidatos != null && count($candidatos) > 0) {
                return redirect()->back()->with([
                    "error" => "Não é possivel alterar o tipo do público, pois existem agendamentos que o reverenciam.",
                ]);
            }
        }

        if (!($request->input('outras_informações') != null) && $etapa->outrasInfo != null && count($etapa->outrasInfo) > 0) {
            foreach ($etapa->outrasInfo as $outra) {
                if ($outra->agendamentos != null && count($outra->agendamentos) > 0) {
                    return redirect()->back()->with([
                        "error" => "Não é possivel excluir as outras opções do público, pois existem agendamentos que o reverenciam.",
                    ]);
                }
            }
        }

        if ($request->input('outrasInfo_id') != null && count($request->input('outrasInfo_id')) > 0) {
            $requestOutras = collect($request->input('outrasInfo_id'));
            $outrasInfoEtapa = $etapa->outrasInfo;
            foreach ($outrasInfoEtapa as $outra) {
                if (!($requestOutras->contains($outra->id))) {
                    return redirect()->back()->with([
                        "error" => "Não é possivel excluir as outras opções do público, pois existem agendamentos que o reverenciam.",
                    ]);
                }
            }
        }

        $etapa->texto = $request->texto_do_agendamento;
        $etapa->texto_home = $request->texto_da_home;
        
        if ($request->texto_das_outras_informações != null) {
            $etapa->texto_outras_informacoes = $request->texto_das_outras_informações;
        }

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

        if ($request->tipo != $etapa->tipo) {
            if ($request->tipo == Etapa::TIPO_ENUM[0] && $etapa->tipo == Etapa::TIPO_ENUM[2]) {
                foreach ($etapa->opcoes as $opcao) {
                    $opcao->delete();
                }

                $etapa->inicio_intervalo = $request->input("inicio_faixa_etária");
                $etapa->fim_intervalo = $request->input("fim_faixa_etária");

            } else if ($request->tipo == Etapa::TIPO_ENUM[2] && $etapa->tipo == Etapa::TIPO_ENUM[0]) {
                $etapa->inicio_intervalo = null;
                $etapa->fim_intervalo = null;

                foreach ($request->opcoes as $op) {
                    $opcaoEtapa = new OpcoesEtapa();
                    $opcaoEtapa->opcao = $op;
                    $opcaoEtapa->etapa_id = $etapa->id;
                    $opcaoEtapa->save();
                }
            } else if ($request->tipo == Etapa::TIPO_ENUM[0] && $etapa->tipo == Etapa::TIPO_ENUM[1]) {
                $etapa->inicio_intervalo = $request->input("inicio_faixa_etária");
                $etapa->fim_intervalo = $request->input("fim_faixa_etária");
            } else if ($request->tipo == Etapa::TIPO_ENUM[1] && $etapa->tipo == Etapa::TIPO_ENUM[0]) {
                $etapa->inicio_intervalo = null;
                $etapa->fim_intervalo = null;
            } else if ($request->tipo == Etapa::TIPO_ENUM[1] && $etapa->tipo == Etapa::TIPO_ENUM[2]) {
                foreach ($etapa->opcoes as $opcao) {
                    $opcao->delete();
                }
            } else if ($request->tipo == Etapa::TIPO_ENUM[2] && $etapa->tipo == Etapa::TIPO_ENUM[1]) {
                foreach ($request->opcoes as $op) {
                    $opcaoEtapa = new OpcoesEtapa();
                    $opcaoEtapa->opcao = $op;
                    $opcaoEtapa->etapa_id = $etapa->id;
                    $opcaoEtapa->save();
                }
            }

            $etapa->tipo = $request->tipo;
        } else {
            if ($request->tipo == Etapa::TIPO_ENUM[0]) {
                $etapa->inicio_intervalo = $request->input("inicio_faixa_etária");
                $etapa->fim_intervalo = $request->input("fim_faixa_etária");
            } else if ($request->tipo == Etapa::TIPO_ENUM[2]) {
                $requestOpcoes = collect($request->input('op_ids'));
                $opcaoEtapa = $etapa->opcoes;
                // Opções excluidas
                foreach ($opcaoEtapa as $op) {
                    if (!($requestOpcoes->contains($op->id))) {
                        $op->delete();
                    // Se ainda estiver contido atualizo
                    } else {
                        $key = array_search($op->id, $request->input('op_ids'));
                        $op->opcao = $request->input('opcoes')[$key];
                        $op->update();
                    }
                }

                // Adiciona novas opções
                foreach ($request->input('op_ids') as $i => $op) {
                    if ($op == 0) {
                        $opcaoEtapa = new OpcoesEtapa();
                        $opcaoEtapa->opcao = $request->input('opcoes')[$i];
                        $opcaoEtapa->etapa_id = $etapa->id;
                        $opcaoEtapa->save();
                    }
                }
            }
        }

        if ($request->pontos != null) {
            $pontos = $etapa->pontos;
            foreach ($pontos as $ponto) {
                $etapa->pontos()->detach($ponto->id);
            }

            foreach ($request->pontos as $ponto) {
                $etapa->pontos()->attach($ponto);
            }
        }

        if (!($request->input('outras_informações') != null) && $etapa->outrasInfo != null && count($etapa->outrasInfo) > 0) {
            foreach ($etapa->outrasInfo as $outra) {
                $outra->delete();
            }
        }

        if ($request->input('outrasInfo_id') != null && count($request->input('outrasInfo_id')) > 0) { 
            $requestOutras = collect($request->input('outrasInfo_id'));
            $outrasInfoEtapa = $etapa->outrasInfo;

            // Excluir opções
            foreach ($outrasInfoEtapa as $outra) {
                if (!($requestOutras->contains($outra->id))) {
                    $outra->delete();
                    // Se ainda estiver contido atualizo
                } else {
                    $key = array_search($outra->id, $request->input('outrasInfo_id'));
                    $outra->campo = $request->input('outrasInfo')[$key];
                    $outra->update();
                }
            }

            // Adiciona novas opções
            foreach ($request->input('outrasInfo_id') as $i => $outra) {
                if ($outra == 0) {
                    $outraInfo = new OutrasInfoEtapa();
                    $outraInfo->campo = $request->input('outrasInfo')[$i];
                    $outraInfo->etapa_id = $etapa->id;
                    $outraInfo->save();
                }
            }
        }


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
            return redirect( route('etapas.index') )->with(['error' => 'Existem agendamentos nesse público, logo não é possivel excluir.']);
        }

        if ($etapa->tipo == Etapa::TIPO_ENUM[2]) {
            $opcoesEtapa = $etapa->opcoes;

            foreach ($opcoesEtapa as $opcao) {
                $opcao->delete();
            }
        }

        $etapa->delete();

        return redirect( route('etapas.index') )->with(['mensagem' => 'Público excluida com sucesso!']);
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
