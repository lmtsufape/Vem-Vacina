<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Lote;
use App\Models\Etapa;
use Carbon\CarbonPeriod;
use App\Models\Candidato;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PostoVacinacaoController extends Controller
{
    public function horarios($posto_id) {
        // Cria uma lista de possiveis horarios do proximo dia quando o posto abre
        // até a proxima semana, removendo os final de semanas

        $todos_os_horarios_por_dia = [];
        $todos_os_horarios = [];

        $posto = PostoVacinacao::find($posto_id);

        // Pega os proximos 7 dias
        for($i = 0; $i < 7; $i++) {
            $dia = Carbon::tomorrow()->addDay($i);

            // Não adiciona os dias caso não funcione nesses dias
            if(!($posto->funciona_domingo) && $dia->isSunday()) {continue;}
            if(!($posto->funciona_segunda) && $dia->isMonday()) {continue;}
            if(!($posto->funciona_terca) && $dia->isTuesday()) {continue;}
            if(!($posto->funciona_quarta) && $dia->isWednesday()) {continue;}
            if(!($posto->funciona_quinta) && $dia->isThursday()) {continue;}
            if(!($posto->funciona_sexta) && $dia->isFriday()) {continue;}
            if(!($posto->funciona_sabado) && $dia->isSaturday()) {continue;}

            if($posto->inicio_atendimento_manha && $posto->intervalo_atendimento_manha && $posto->fim_atendimento_manha) {
                $inicio_do_dia = $dia->copy()->addHours($posto->inicio_atendimento_manha);
                $fim_do_dia = $dia->copy()->addHours($posto->fim_atendimento_manha);
                $periodos_da_manha = CarbonPeriod::create($inicio_do_dia, $posto->intervalo_atendimento_manha . " minutes", $fim_do_dia);
                array_push($todos_os_horarios_por_dia, $periodos_da_manha);
            }

            if($posto->inicio_atendimento_tarde && $posto->intervalo_atendimento_tarde && $posto->fim_atendimento_tarde) {
                $inicio_do_dia = $dia->copy()->addHours($posto->inicio_atendimento_tarde);
                $fim_do_dia = $dia->copy()->addHours($posto->fim_atendimento_tarde);
                $periodos_da_tarde = CarbonPeriod::create($inicio_do_dia, $posto->intervalo_atendimento_tarde . " minutes", $fim_do_dia);
                array_push($todos_os_horarios_por_dia, $periodos_da_tarde);
            }
        }

        // Os periodos são salvos como horarios[dia][janela]
        // Esse loop planificado o array pra horarios[janela]
        foreach($todos_os_horarios_por_dia as $dia) {
            foreach($dia as $janela) {
                array_push($todos_os_horarios, $janela);
            }
        }

        // Pega os candidatos do posto selecionado cuja data de vacinação é de amanhã pra frente, os que já passaram não importam
        $candidatos = Candidato::where("posto_vacinacao_id", $posto_id)->whereDate('chegada', '>=', Carbon::tomorrow()->toDateString())->get();

        $horarios_disponiveis = [];


        // Remove os horarios já agendados por outros candidados
        foreach($todos_os_horarios as $horario) {
            $horario_ocupado = false;
            foreach($candidatos as $candidato) {
                if($candidato->aprovacao != Candidato::APROVACAO_ENUM[2]) { // Todos que NÃO foram reprovados
                    if($horario->equalTo($candidato->chegada)) {
                        $horario_ocupado = true;
                        break;
                    }
                }
            }

            if(!$horario_ocupado) {
                array_push($horarios_disponiveis, $horario);
            }
        }

        $horarios_agrupados_por_dia = [];

        // Agrupa os horarios disponiveis por dia pra mostrar melhor no html
        foreach($horarios_disponiveis as $h) {
            $inicio_do_dia = $h->copy()->startOfDay()->format("d/m/Y");
            if(!isset($horarios_agrupados_por_dia[$inicio_do_dia])) {
                $horarios_agrupados_por_dia[$inicio_do_dia] = [];
            }
            array_push($horarios_agrupados_por_dia[$inicio_do_dia], $h);
        }

        // return $horarios_agrupados_por_dia;
        return view('seletor_horario_form', ["horarios_por_dia" => $horarios_agrupados_por_dia]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('ver-posto');
        $lotes = DB::table("lote_posto_vacinacao")->get();
        $tipos = Etapa::TIPO_ENUM;
        $postos = PostoVacinacao::orderBy('nome')->paginate(10);

        return view('postos.index', compact('postos', 'lotes','tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('criar-posto');
        $etapas = Etapa::where([['atual', true], ['tipo', '!=', Etapa::TIPO_ENUM[3]]])->get();
        return view('postos.store')->with(['publicos' => $etapas, 'tipos' => Etapa::TIPO_ENUM]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('criar-posto');
        $data = $request->all();
        $rules = [
            'nome'       => 'required|unique:posto_vacinacaos',
            'endereco'   => 'required|max:100',
            'publicos'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules );

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $posto = new PostoVacinacao();

        $posto->nome = $request->nome;
        $posto->endereco = $request->endereco;

        if ($request->padrao_no_formulario) {
            $posto->padrao_no_formulario = true;
        } else {
            $posto->padrao_no_formulario = false;
        }

        $posto->funciona_domingo = ($request->funciona_domingo == "on");
        $posto->funciona_segunda = ($request->funciona_segunda == "on");
        $posto->funciona_terca = ($request->funciona_terca == "on");
        $posto->funciona_quarta = ($request->funciona_quarta == "on");
        $posto->funciona_quinta = ($request->funciona_quinta == "on");
        $posto->funciona_sexta = ($request->funciona_sexta == "on");
        $posto->funciona_sabado = ($request->funciona_sabado == "on");


        if($request->funcionamento_manha == "on") {
            $request->validate([
                "inicio_atendimento_manha" => "required|integer",
                "intervalo_atendimento_manha" => "required|integer",
                "fim_atendimento_manha" => "required|integer|gt:inicio_atendimento_manha",
            ]);

            $posto->inicio_atendimento_manha = $request->inicio_atendimento_manha;
            $posto->intervalo_atendimento_manha = $request->intervalo_atendimento_manha;
            $posto->fim_atendimento_manha = $request->fim_atendimento_manha;
        } else {
            $posto->inicio_atendimento_manha = NULL;
            $posto->intervalo_atendimento_manha = NULL;
            $posto->fim_atendimento_manha = NULL;
        }

        $posto->save();


        if ($request->publicos != null) {
            foreach ($request->publicos as $publico_id) {
                $posto->etapas()->attach($publico_id);
            }
        }

        return redirect()->route('postos.index')->with('message', 'Posto criado com sucesso!');
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
        Gate::authorize('editar-posto');
        $posto = PostoVacinacao::findOrFail($id);
        $etapas = Etapa::where([['atual', true], ['tipo', '!=', Etapa::TIPO_ENUM[3]]])->get();
        $etapasDoPosto = $posto->etapas()->select('etapa_id')->get();
        return view('postos.edit')->with(['posto' => $posto,
                                          'publicos' => $etapas,
                                          'tipos' => Etapa::TIPO_ENUM,
                                          'publicosDoPosto' => $etapasDoPosto,]);
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
        Gate::authorize('editar-posto');

        $rules = [
            'nome'       => 'required',
            'endereco'   => 'required|max:100',
            'publicos'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules );

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->all();
        $posto = PostoVacinacao::find($id);

        $posto->nome = $request->nome;
        $posto->endereco = $request->endereco;

        if ($request->padrao_no_formulario) {
            $posto->padrao_no_formulario = true;
        } else {
            $posto->padrao_no_formulario = false;
        }

        $posto->funciona_domingo = ($request->funciona_domingo == "on");
        $posto->funciona_segunda = ($request->funciona_segunda == "on");
        $posto->funciona_terca = ($request->funciona_terca == "on");
        $posto->funciona_quarta = ($request->funciona_quarta == "on");
        $posto->funciona_quinta = ($request->funciona_quinta == "on");
        $posto->funciona_sexta = ($request->funciona_sexta == "on");
        $posto->funciona_sabado = ($request->funciona_sabado == "on");


        if($request->funcionamento_manha == "on") {
            $request->validate([
                "inicio_atendimento_manha" => "required|integer",
                "intervalo_atendimento_manha" => "required|integer",
                "fim_atendimento_manha" => "required|integer|gt:inicio_atendimento_manha",
            ]);

            $posto->inicio_atendimento_manha = $request->inicio_atendimento_manha;
            $posto->intervalo_atendimento_manha = $request->intervalo_atendimento_manha;
            $posto->fim_atendimento_manha = $request->fim_atendimento_manha;
        } else {
            $posto->inicio_atendimento_manha = NULL;
            $posto->intervalo_atendimento_manha = NULL;
            $posto->fim_atendimento_manha = NULL;
        }

        if($request->funcionamento_tarde == "on") {
            $request->validate([
                "inicio_atendimento_tarde" => "required|integer",
                "intervalo_atendimento_tarde" => "required|integer",
                "fim_atendimento_tarde" => "required|integer|gt:inicio_atendimento_tarde",
            ]);

            $posto->inicio_atendimento_tarde = $request->inicio_atendimento_tarde;
            $posto->intervalo_atendimento_tarde = $request->intervalo_atendimento_tarde;
            $posto->fim_atendimento_tarde = $request->fim_atendimento_tarde;
        } else {
            $posto->inicio_atendimento_tarde = NULL;
            $posto->intervalo_atendimento_tarde = NULL;
            $posto->fim_atendimento_tarde = NULL;
        }

        $posto->update();

        if ($request->publicos != null) {
            foreach ($posto->etapas as $key => $etapa) {
                $posto->etapas()->detach($etapa->id);
            }

            foreach ($request->publicos as $publico_id) {
                $posto->etapas()->attach($publico_id);
            }
        }

        return redirect()->route('postos.index')->with('message', 'Posto editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('apagar-posto');
        $posto = PostoVacinacao::findOrFail($id);
        if($posto->lotes->count()) {
            return redirect()->back()->withErrors([
                "message" => "Existe lote associado com esse ponto de vacinação."
            ])->withInput();

        }
        $posto->forceDelete();

        return redirect()->route('postos.index')->with('message', 'Posto excluído com sucesso!');
    }

    public function todosOsPostos(Request $request) {
        $etapa = null;
        $postos = Etapa::find($request->publico_id)->pontos;
        $postos_disponiveis = collect([]);
        // $etapa = Etapa::where('id',$request->publico_id)->first();
        foreach ($postos as $key => $posto) {
            $lote_bool = false;
            foreach($posto->lotes as $key1 => $lote){
                if($lote->pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote->pivot->id)->count() > 0 && $lote->etapas->find($request->publico_id) && count($this->diasPorPostoDois($posto)) != 0){
                    $lote_bool = true;
                    break;
                }
            }

            if($lote_bool == true){
                $postos_disponiveis->push($posto);
                continue;
            }
        }
        // return response()->json( $this->diasPorPostoDois($postos_disponiveis->first()) );



        if ($request->publico_id == 0) {
            $pontos = PostoVacinacao::where('padrao_no_formulario', true)->get();
            $filtered = $pontos->filter(function ($value1, $key1) use($postos) {
                return $postos->find($value1->id) != null;
            });
            return response()->json($filtered->values());
        } else {
            $postos_disponiveis = array_values($postos_disponiveis->toArray());
            return response()->json($postos_disponiveis);
        }


    }

    public function diasPorPosto(Request $request) {
        if ($request->posto_id != null) {
            // Cria uma lista de possiveis horarios do proximo dia quando o posto abre
            // até a proxima semana, removendo os final de semanas

            $todos_os_horarios_por_dia = [];
            $todos_os_horarios = [];

            $posto = PostoVacinacao::find($request->posto_id);

            // Pega os proximos 7 dias
            for($i = 0; $i < 7; $i++) {
                $dia = Carbon::tomorrow()->addDay($i);

                // Não adiciona os dias caso não funcione nesses dias
                if(!($posto->funciona_domingo) && $dia->isSunday()) {continue;}
                if(!($posto->funciona_segunda) && $dia->isMonday()) {continue;}
                if(!($posto->funciona_terca) && $dia->isTuesday()) {continue;}
                if(!($posto->funciona_quarta) && $dia->isWednesday()) {continue;}
                if(!($posto->funciona_quinta) && $dia->isThursday()) {continue;}
                if(!($posto->funciona_sexta) && $dia->isFriday()) {continue;}
                if(!($posto->funciona_sabado) && $dia->isSaturday()) {continue;}

                if($posto->inicio_atendimento_manha && $posto->intervalo_atendimento_manha && $posto->fim_atendimento_manha) {
                    $inicio_do_dia = $dia->copy()->addHours($posto->inicio_atendimento_manha);
                    $fim_do_dia = $dia->copy()->addHours($posto->fim_atendimento_manha);
                    $periodos_da_manha = CarbonPeriod::create($inicio_do_dia, $posto->intervalo_atendimento_manha . " minutes", $fim_do_dia);
                    array_push($todos_os_horarios_por_dia, $periodos_da_manha);
                }

                if($posto->inicio_atendimento_tarde && $posto->intervalo_atendimento_tarde && $posto->fim_atendimento_tarde) {
                    $inicio_do_dia = $dia->copy()->addHours($posto->inicio_atendimento_tarde);
                    $fim_do_dia = $dia->copy()->addHours($posto->fim_atendimento_tarde);
                    $periodos_da_tarde = CarbonPeriod::create($inicio_do_dia, $posto->intervalo_atendimento_tarde . " minutes", $fim_do_dia);
                    array_push($todos_os_horarios_por_dia, $periodos_da_tarde);
                }
            }

            // Os periodos são salvos como horarios[dia][janela]
            // Esse loop planificado o array pra horarios[janela]
            foreach($todos_os_horarios_por_dia as $dia) {
                foreach($dia as $janela) {
                    array_push($todos_os_horarios, $janela);
                }
            }

            // Pega os candidatos do posto selecionado cuja data de vacinação é de amanhã pra frente, os que já passaram não importam
            $candidatos = Candidato::where("posto_vacinacao_id", $request->posto_id)->whereDate('chegada', '>=', Carbon::tomorrow()->toDateString())->get();

            $horarios_disponiveis = [];


            // Remove os horarios já agendados por outros candidados
            foreach($todos_os_horarios as $horario) {
                $horario_ocupado = false;
                foreach($candidatos as $candidato) {
                    if($candidato->aprovacao != Candidato::APROVACAO_ENUM[2]) { // Todos que NÃO foram reprovados
                        if($horario->equalTo($candidato->chegada)) {
                            $horario_ocupado = true;
                            break;
                        }
                    }
                }

                if(!$horario_ocupado) {
                    array_push($horarios_disponiveis, $horario);
                }
            }

            $horarios_agrupados_por_dia = [];

            // Agrupa os horarios disponiveis por dia pra mostrar melhor no html
            foreach($horarios_disponiveis as $h) {
                $inicio_do_dia = $h->copy()->startOfDay()->format("d/m/Y");
                if(!isset($horarios_agrupados_por_dia[$inicio_do_dia])) {
                    $horarios_agrupados_por_dia[$inicio_do_dia] = [];
                }
                array_push($horarios_agrupados_por_dia[$inicio_do_dia], $h);
            }

            return response()->json($horarios_agrupados_por_dia);
        }

        abort(404);
    }
    public function diasPorPostoDois($posto) {
        if ($posto->id != null) {
            // Cria uma lista de possiveis horarios do proximo dia quando o posto abre
            // até a proxima semana, removendo os final de semanas

            $todos_os_horarios_por_dia = [];
            $todos_os_horarios = [];

            $posto = PostoVacinacao::find($posto->id);

            // Pega os proximos 7 dias
            for($i = 0; $i < 7; $i++) {
                $dia = Carbon::tomorrow()->addDay($i);

                // Não adiciona os dias caso não funcione nesses dias
                if(!($posto->funciona_domingo) && $dia->isSunday()) {continue;}
                if(!($posto->funciona_segunda) && $dia->isMonday()) {continue;}
                if(!($posto->funciona_terca) && $dia->isTuesday()) {continue;}
                if(!($posto->funciona_quarta) && $dia->isWednesday()) {continue;}
                if(!($posto->funciona_quinta) && $dia->isThursday()) {continue;}
                if(!($posto->funciona_sexta) && $dia->isFriday()) {continue;}
                if(!($posto->funciona_sabado) && $dia->isSaturday()) {continue;}

                if($posto->inicio_atendimento_manha && $posto->intervalo_atendimento_manha && $posto->fim_atendimento_manha) {
                    $inicio_do_dia = $dia->copy()->addHours($posto->inicio_atendimento_manha);
                    $fim_do_dia = $dia->copy()->addHours($posto->fim_atendimento_manha);
                    $periodos_da_manha = CarbonPeriod::create($inicio_do_dia, $posto->intervalo_atendimento_manha . " minutes", $fim_do_dia);
                    array_push($todos_os_horarios_por_dia, $periodos_da_manha);
                }

                if($posto->inicio_atendimento_tarde && $posto->intervalo_atendimento_tarde && $posto->fim_atendimento_tarde) {
                    $inicio_do_dia = $dia->copy()->addHours($posto->inicio_atendimento_tarde);
                    $fim_do_dia = $dia->copy()->addHours($posto->fim_atendimento_tarde);
                    $periodos_da_tarde = CarbonPeriod::create($inicio_do_dia, $posto->intervalo_atendimento_tarde . " minutes", $fim_do_dia);
                    array_push($todos_os_horarios_por_dia, $periodos_da_tarde);
                }
            }

            // Os periodos são salvos como horarios[dia][janela]
            // Esse loop planificado o array pra horarios[janela]
            foreach($todos_os_horarios_por_dia as $dia) {
                foreach($dia as $janela) {
                    array_push($todos_os_horarios, $janela);
                }
            }

            // Pega os candidatos do posto selecionado cuja data de vacinação é de amanhã pra frente, os que já passaram não importam
            $candidatos = Candidato::where("posto_vacinacao_id", $posto->id)->whereDate('chegada', '>=', Carbon::tomorrow()->toDateString())->get();

            $horarios_disponiveis = [];


            // Remove os horarios já agendados por outros candidados
            foreach($todos_os_horarios as $horario) {
                $horario_ocupado = false;
                foreach($candidatos as $candidato) {
                    if($candidato->aprovacao != Candidato::APROVACAO_ENUM[2]) { // Todos que NÃO foram reprovados
                        if($horario->equalTo($candidato->chegada)) {
                            $horario_ocupado = true;
                            break;
                        }
                    }
                }

                if(!$horario_ocupado) {
                    array_push($horarios_disponiveis, $horario);
                }
            }

            $horarios_agrupados_por_dia = [];

            // Agrupa os horarios disponiveis por dia pra mostrar melhor no html
            foreach($horarios_disponiveis as $h) {
                $inicio_do_dia = $h->copy()->startOfDay()->format("d/m/Y");
                if(!isset($horarios_agrupados_por_dia[$inicio_do_dia])) {
                    $horarios_agrupados_por_dia[$inicio_do_dia] = [];
                }
                array_push($horarios_agrupados_por_dia[$inicio_do_dia], $h);
            }

            return $horarios_agrupados_por_dia;
        }

        return [];
    }
}

//*******************************
        // foreach ($postos as $key => $posto) {

        //     if(!$etapa->lotes->count()){
        //         $postos->pull($key);
        //         continue;
        //     }
        //     //Retorna um array de IDs do lotes associados a etapa escolhida
        //     $array_lotes_disponiveis = $etapa->lotes->pluck('id');


        //     // Pega a lista de todos os lotes da etapa escolhida para o posto escolhido
        //     $lotes_disponiveis = DB::table("lote_posto_vacinacao")->where("posto_vacinacao_id", $posto->id)
        //                             ->whereIn('lote_id', $array_lotes_disponiveis)->get();

        //     $id_lote = 0;

        //     // Pra cada lote que esteje no posto
        //     foreach ($lotes_disponiveis as $lote) {

        //         // Se a quantidade de candidatos à tomar a vicina daquele lote, naquele posto, que não foram reprovados
        //         // for menor que a quantidade de vacinas daquele lote que foram pra aquele posto, então o candidato vai tomar
        //         // daquele lote

        //         $lote_original = Lote::find($lote->lote_id);
        //         $qtdCandidato = Candidato::where("lote_id", $lote->id)->where("posto_vacinacao_id", $posto->id)->where("aprovacao",  Candidato::APROVACAO_ENUM[1])
        //                                     ->count();
        //         if(!$lote_original->dose_unica){
        //             //Se o lote disponivel for de vacina com dose dupla vai parar aqui
        //             //e verifica se tem duas vacinas disponiveis
        //             if (($qtdCandidato + 1) < $lote->qtdVacina) {
        //                 $id_lote = $lote->id;
        //                 $chave_estrangeiro_lote = $lote->lote_id;
        //                 $qtd = $lote->qtdVacina - $qtdCandidato;

        //                 if ( !$lote_original->dose_unica && !($qtd >= 2) ) {
        //                     $postos->pull($key);
        //                     // return redirect()->back()->withErrors([
        //                     //     "posto_vacinacao" => "Não há mais doses disponíveis. Favor realize o seu cadastro na fila de espera pela página principal."
        //                     // ])->withInput();
        //                 }
        //                 continue;
        //             }

        //         }else{
        //             //Se o lote disponivel for de vacina com dose unica vai parar aqui
        //             //e verifica se tem pelo menos uma ou mais vacinas disponiveis
        //             if ($qtdCandidato < $lote->qtdVacina) {
        //                 $id_lote = $lote->id;
        //                 $chave_estrangeiro_lote = $lote->lote_id;
        //                 continue;
        //             }
        //         }

        //     }

        //     if ($id_lote == 0) { // Se é 0 é porque não tem vacinas...
        //         $postos->pull($key);
        //     }
        // }
        //*******************************
        // public const APROVACAO_ENUM = ["Não Analisado", "Aprovado", "Reprovado", "Vacinado"];
        // foreach ($postos as $key1 => $posto) {
        //     foreach ($posto->lotes as $key => $lote) {
        //         $qtdC = Candidato::where("lote_id", $lote->id)->where("posto_vacinacao_id", $posto->id)->where("aprovacao",  Candidato::APROVACAO_ENUM[1])
        //         ->count();
        //         $qtdV = $lote->pivot->qtdVacina;

        //         if(0 == $qtdV - $qtdC || 0 == $qtdV - ($qtdC + 1)){
        //             $postos->pull($key1);
        //         }
        //     }
        //     if(!$posto->lotes->count()){
        //         $postos->pull($key1);
        //         continue;
        //     }
        // }

        //******************************* */
        // $etapa = Etapa::find($request->publico_id);

        // try {
        //     foreach ($postos as $key1 => $posto) {

        //         if(!$etapa->lotes->count()){
        //             $postos->pull($key1);
        //             continue;
        //         }
        //         foreach ($etapa->lotes as $key2 => $lote) {
        //             DB::table('lote_posto_vacinacao')->where("posto_vacinacao_id", $posto->id)->where('lote_id', $lote->id)->first();
        //             $qtdCandidato = DB::table('candidatos')->where("posto_vacinacao_id",$posto->id)->where('lote_id', $lote->id)->count();
        //             if(DB::table('lote_posto_vacinacao')->where("posto_vacinacao_id", $posto->id)->where('lote_id', $lote->id)->first() == null){
        //                 $postos->pull($key1);
        //                 continue;

        //             }
        //             $qtdVacina = DB::table('lote_posto_vacinacao')->where("posto_vacinacao_id", $posto->id)->where('lote_id', $lote->id)->first()->qtdVacina;
        //             if($qtdCandidato == $qtdVacina || $qtdVacina == $qtdCandidato + 1){
        //                 $postos->pull($key1);
        //                 // return response()->json("teste");
        //                 continue;
        //             }

        //         }
        //         foreach ($posto->lotes as $key2 => $lote) {
        //             $qtdCandidato = DB::table('candidatos')->where("posto_vacinacao_id",$posto->id)->where('lote_id', $lote->pivot->id)->count();
        //             $qtdVacina = DB::table('lote_posto_vacinacao')->where("posto_vacinacao_id", $posto->id)->where('lote_id', $lote->id)->first()->qtdVacina;

        //             if($qtdCandidato == $qtdVacina || $qtdVacina == $qtdCandidato + 1){
        //                 $postos->pull($key1);
        //                 // return response()->json("teste");
        //                 continue;

        //             }
        //         }
        //     }
        // } catch (\Throwable $th) {
        //     return response()->json($th->getMessage());
        // }
        //******************************* */
