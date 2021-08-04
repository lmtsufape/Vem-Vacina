<?php

namespace App\Http\Controllers;


use DateTime;
use Carbon\Carbon;
use App\Models\Lote;
use App\Models\Etapa;
use Carbon\CarbonPeriod;
use App\Models\Candidato;
use App\Models\Dia;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use App\Models\LotePostoVacinacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\HorariosAgrupadosPorDia;

class PostoVacinacaoController extends Controller
{
    use HorariosAgrupadosPorDia {
        horarios as protected traitHorarios;
    }
    public function horarios($posto_id) {

        $horarios_agrupados_por_dia = $this->traitHorarios($posto_id);

        return view('seletor_horario_form', ["horarios_por_dia" => $horarios_agrupados_por_dia]);

    }


    public function index_novo(Request $request)
    {
        Gate::authorize('ver-posto');
        $lotes_pivot = LotePostoVacinacao::with(['lote', 'posto'])->get();
        // $posts = Post::withCount(['votes', 'comments' => function (Builder $query) {
        //     $query->where('content', 'like', 'code%');
        // }])->get();
        // $posto->candidatos()->where('lote_id', $lote_pivot->id)->count()
        $tipos = Etapa::TIPO_ENUM;
        $todosPosto = PostoVacinacao::where('status', '!=', 'arquivado')->orderBy('nome')->get();
        if($request->posto == null){
            $postos = PostoVacinacao::with(['lotes', 'etapas', 'candidatos'])->where('status', '!=', 'arquivado')->orderBy('nome')->simplePaginate(5);
        }else{
            $postos = PostoVacinacao::where('status', '!=', 'arquivado')->whereIn('id', $request->posto)->orderBy('nome')->simplePaginate(10);
        }
        return view('postos.index_novo', compact('postos', 'lotes_pivot','tipos', 'todosPosto'));
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

    public function arquivar($id, $status)
    {
        Gate::authorize('apagar-posto');
        $posto = PostoVacinacao::find($id);
        $posto->update([
            'status' => $status
        ]);
        return back()->with('message', 'Ponto '.$posto->nome.' atualizado com status \''.$status.'\'!');
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

        return redirect()->route('postos.index.new')->with('message', 'Posto criado com sucesso!');
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
    public function edit(Request $request, $id)
    {
        Gate::authorize('editar-posto');
        $posto = PostoVacinacao::findOrFail($id);
        $etapas = Etapa::where([['atual', true], ['tipo', '!=', Etapa::TIPO_ENUM[3]]])->get();
        $etapasDoPosto = $posto->etapas()->select('etapa_id')->get();
        // dd( redirect()->back()->getTargetUrl());
        session(['url' => redirect()->back()->getTargetUrl()]);
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
        // dd($request->all());
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

        if($request->funcionamento_noite == "on") {
            $request->validate([
                "inicio_atendimento_noite" => "required|integer",
                "intervalo_atendimento_noite" => "required|integer",
                "fim_atendimento_noite" => "required|integer|gt:inicio_atendimento_noite",
            ]);

            $posto->inicio_atendimento_noite = $request->inicio_atendimento_noite;
            $posto->intervalo_atendimento_noite = $request->intervalo_atendimento_noite;
            $posto->fim_atendimento_noite = $request->fim_atendimento_noite;
        } else {
            $posto->inicio_atendimento_noite = NULL;
            $posto->intervalo_atendimento_noite = NULL;
            $posto->fim_atendimento_noite = NULL;
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
        if ($request->session()->has('url')) {

            return redirect(session('url', 'dashboard'))->with(['message' => 'Ponto '.$posto->nome.' editado com sucesso!']);

        }

        return redirect()->route('postos.index.new')->with('message', 'Ponto '.$posto->nome.' editado com sucesso!');
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

        return redirect()->route('postos.index.new')->with('message', 'Posto excluído com sucesso!');
    }

    public function todosOsPostos(Request $request) {

        try {

            if ($request->publico_id == 0) {
                $pontos = PostoVacinacao::where('padrao_no_formulario', true)->get();

                return response()->json($pontos);
            } else {
                set_time_limit(40);
                $candidato_count = Candidato::where('etapa_id', $request->publico_id)->where('aprovacao',Candidato::APROVACAO_ENUM[0])->count();
                if($candidato_count <= 15){
                    $postos = Etapa::find($request->publico_id)->pontos->where('status', '!=', 'arquivado');
                    $postos_disponiveis = collect([]);
                    foreach ($postos as $key => $posto) {
                        $lote_bool = false;
                        foreach($posto->lotes as $key1 => $lote){
                            if($lote->pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote->pivot->id)->count() > 0 && $lote->etapas->find($request->publico_id)){
                                $lote_bool = true;
                                break;
                            }
                        }

                        if($lote_bool == true){
                            $postos_disponiveis->push($posto);
                            continue;
                        }
                    }

                    $postos_disponiveis = array_values($postos_disponiveis->toArray());
                    return response()->json($postos_disponiveis);
                }else{
                    return response()->json([]);

                }
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }



    }

    public function diasPorPosto(Request $request) {


        if ($request->posto_id != null) {
            $horarios_agrupados_por_dia = $this->traitHorarios($request->posto_id);
            return response()->json($horarios_agrupados_por_dia);
        }
        abort(404);

    }

    public function geradorHorarios($id = null)
    {
        set_time_limit(720);
        \Log::info('geradorHorarios');
        if ($id == null) {
            $postos = PostoVacinacao::where('status', '!=', 'arquivado')->get();
        }else{
            $postos = PostoVacinacao::where('id', $id)->get();
        }

        foreach ($postos as $key => $posto) {
            // Cria uma lista de possiveis horarios do proximo dia quando o posto abre
            // até a proxima semana, removendo os final de semanas

            $todos_os_horarios_por_dia = [];
            $todos_os_horarios = [];

            $qtdDias = $posto->dias()->whereDate('dia', '>=', now())->count();

            if ($qtdDias >= 3) {
                $contador = 1;
            } elseif ($qtdDias == 0) {
                $contador = 0;
            }else{
                $contador = 1;
                $contador = 1;
            }
            // \Log::info($contador);
            $posto->dias()->whereDate('dia', '<=', now())->forceDelete();
            // Pega os proximos 3 disponiveis dias
            for($i = 0; $i < 7; $i++) {
                if ($qtdDias == 0) {
                    $dia = Carbon::tomorrow()->addDay($i);
                }else{
                    $dia = $posto->dias->sortDesc()->first()->dia->addDay($i);
                }

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

                if($posto->inicio_atendimento_noite && $posto->intervalo_atendimento_noite && $posto->fim_atendimento_noite) {
                    $inicio_do_dia = $dia->copy()->addHours($posto->inicio_atendimento_noite);
                    $fim_do_dia = $dia->copy()->addHours($posto->fim_atendimento_noite);
                    $periodos_da_tarde = CarbonPeriod::create($inicio_do_dia, $posto->intervalo_atendimento_noite . " minutes", $fim_do_dia);
                    array_push($todos_os_horarios_por_dia, $periodos_da_tarde);
                }

                $contador++;
                if($contador == 3){
                    break;
                }
            }

            // Os periodos são salvos como horarios[dia][janela]
            // Esse loop planificado o array pra horarios[janela]
            foreach($todos_os_horarios_por_dia as $dia) {
                foreach($dia as $janela) {
                    array_push($todos_os_horarios, $janela);
                }
            }
            $candidatos = Candidato::where("posto_vacinacao_id", $posto->id)->whereDate('chegada', '>=', Carbon::tomorrow()->toDateString())->where('aprovacao', Candidato::APROVACAO_ENUM[1])->get();

            $horarios_disponiveis = array_diff($todos_os_horarios, $candidatos->pluck('chegada')->toArray());

            $todos_os_horarios = $horarios_disponiveis;

            foreach($todos_os_horarios as $h) {
                if ($posto->dias->where('dia', date($h->copy()->startOfDay()))->count() == 0) {
                    $dia = $posto->dias()->createMany([['dia' =>date_format($h->copy()->startOfDay(),"d-m-Y") ]]);
                    $posto->refresh();
                } elseif($posto->dias->where('dia', date($h->copy()->startOfDay()))->count() == 1) {
                    $dia = $posto->dias->where('dia', date($h->copy()->startOfDay()))->first();
                    if(!$dia->horarios()->where('horario', date($h))->count()){
                        $dia->horarios()->createMany([['horario' => date($h)]]);
                        // $dia->horarios()->updateOrCreate(
                        //     ['horario' => date($h)],
                        //     ['horario' => date($h)]
                        // );
                    }
                }
            }

        }
        if ($id == null) {
            return true;
        }else{
            return back()->with(['message' => 'Dia gerado com sucesso!']);
        }


    }
}

