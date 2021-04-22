<?php

namespace App\Http\Controllers;

use Throwable;
use DateInterval;
use Carbon\Carbon;
use App\Models\Lote;
use App\Models\User;
use App\Models\Etapa;
use Carbon\CarbonPeriod;
use App\Models\Candidato;
use App\Jobs\DistribuirFila;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Notifications\CandidatoAprovado;
use App\Notifications\CandidatoFilaArquivo;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CandidatoInscritoSegundaDose;



class FilaController extends Controller
{
    public function index(Request $request) {
        // dd($request->all());
        $query = Candidato::query()->where('aprovacao',Candidato::APROVACAO_ENUM[0]);


        if ($request->nome_check && $request->nome != null) {
            $query->where('nome_completo', 'ilike', '%' . $request->nome . '%');
        }

        if ($request->cpf_check && $request->cpf != null) {
            $query->where('cpf', $request->cpf);
        }

        if ($request->publico_check) {
            if ($request->publico != null) {
                $query->where('etapa_id', $request->publico);
            }
        }

        if ($request->ordem_check && $request->ordem != null) {
            if($request->campo != null){
                $query->orderBy($request->campo, $request->ordem);
            }else{
                $query->orderBy('nome_completo', $request->ordem);
            }
        }

        if ($request->campo_check && $request->campo != null) {
            $query->orderBy($request->campo);
        }

        if ($request->outro) {
            $agendamentos = $query->get();
        } else {
            $agendamentos = $query->paginate(500)->withQueryString();
        }

        if ($request->outro) {
            $agendamentosComOutrasInfo = collect();

            foreach ($agendamentos as $agendamento) {
                $outros = $agendamento->outrasInfo;
                if($outros != null && count($outros) > 0) {
                    $agendamentosComOutrasInfo->push($agendamento);
                }
            }

            if ($agendamentosComOutrasInfo->count() > 0) {
                $agendamentos = $agendamentosComOutrasInfo;
            } else {
                $agendamentos = collect();
            }
        }

        return view('fila.index')->with(['candidatos' => $agendamentos,
                                        'candidato_enum' => Candidato::APROVACAO_ENUM,
                                        'tipos' => Etapa::TIPO_ENUM,
                                        'postos' => PostoVacinacao::all(),
                                        'doses' => Candidato::DOSE_ENUM,
                                        'publicos' => Etapa::orderBy('texto_home')->get(),
                                        'request' => $request]);
    }

    public function agendar($horarios_agrupados_por_dia, $candidato_id, $posto_id) {
        $candidato = Candidato::find($candidato_id);

        // var_dump($horarios_agrupados_por_dia);
        foreach ($horarios_agrupados_por_dia as $key1 => $dia) {

            foreach ($dia as $key2 => $horario) {

                $dia_vacinacao          = date('d/m/Y', strtotime($horario));
                $horario_vacinacao      = date('H:i', strtotime($horario));
                $id_posto               = $posto_id;
                $datetime_chegada       = Carbon::createFromFormat("d/m/Y H:i", $dia_vacinacao . " " . $horario_vacinacao);
                $datetime_saida         = $datetime_chegada->copy()->addMinutes(10);
                // dd( $datetime_chegada );
                $candidatos_no_mesmo_horario_no_mesmo_lugar = Candidato::where("chegada", "=", $datetime_chegada)->where("posto_vacinacao_id", $id_posto)->get();

                if ($candidatos_no_mesmo_horario_no_mesmo_lugar->count() > 0) {
                    continue;
                }
                $etapa = $candidato->etapa;

                if(!$etapa->lotes->count()){
                    continue;
                }
                //Retorna um array de IDs do lotes associados a etapa escolhida
                $array_lotes_disponiveis = $etapa->lotes->pluck('id');


                // Pega a lista de todos os lotes da etapa escolhida para o posto escolhido
                $lotes_disponiveis = DB::table("lote_posto_vacinacao")->where("posto_vacinacao_id", $id_posto)
                                        ->whereIn('lote_id', $array_lotes_disponiveis)->get();

                $id_lote = 0;
                // Pra cada lote que esteje no posto
                foreach ($lotes_disponiveis as $lote) {

                    // Se a quantidade de candidatos à tomar a vicina daquele lote, naquele posto, que não foram reprovados
                    // for menor que a quantidade de vacinas daquele lote que foram pra aquele posto, então o candidato vai tomar
                    // daquele lote

                    $lote_original = Lote::find($lote->lote_id);
                    $qtdCandidato = Candidato::where("lote_id", $lote->id)->where("posto_vacinacao_id", $id_posto)->where("aprovacao", "!=", Candidato::APROVACAO_ENUM[2])->where("aprovacao", "!=", Candidato::APROVACAO_ENUM[0])
                                                ->count();
                    if(!$lote_original->dose_unica){
                        //Se o lote disponivel for de vacina com dose dupla vai parar aqui
                        //e verifica se tem duas vacinas disponiveis
                        if (($qtdCandidato + 1) < $lote->qtdVacina) {
                            $id_lote = $lote->id;
                            $chave_estrangeiro_lote = $lote->lote_id;
                            $qtd = $lote->qtdVacina - $qtdCandidato;

                            if ( !$lote_original->dose_unica && !($qtd >= 2) ) {
                                continue;
                                // return redirect()->back()->withErrors([
                                //     'posto_vacinacao_' . $id => "Não há mais doses disponíveis."
                                // ])->withInput();
                            }
                            break;
                        }

                    }else{
                        //Se o lote disponivel for de vacina com dose unica vai parar aqui
                        //e verifica se tem pelo menos uma ou mais vacinas disponiveis
                        if ($qtdCandidato < $lote->qtdVacina) {
                            $id_lote = $lote->id;
                            $chave_estrangeiro_lote = $lote->lote_id;
                            break;
                        }
                    }

                }

                if ($id_lote == 0) { // Se é 0 é porque não tem vacinas...
                    continue;
                }
                // dd($id_lote);
                $candidato->posto_vacinacao_id      = $id_posto;
                $candidato->chegada                 = $datetime_chegada;
                $candidato->saida                   = $datetime_saida;
                $candidato->lote_id                 = $id_lote;
                $candidato->update();

                $lote = Lote::find($chave_estrangeiro_lote);
                $candidato->aprovacao = Candidato::APROVACAO_ENUM[1];
                $candidato->update();
                if (!$lote->dose_unica) {
                    $datetime_chegada_segunda_dose = $candidato->chegada->add(new DateInterval('P'.$lote->inicio_periodo.'D'));
                    if($datetime_chegada_segunda_dose->format('l') == "Sunday"){
                        $datetime_chegada_segunda_dose->add(new DateInterval('P1D'));
                    }
                    $candidatoSegundaDose = $candidato->replicate()->fill([
                        'aprovacao' =>  Candidato::APROVACAO_ENUM[1],
                        'chegada' =>  $datetime_chegada_segunda_dose,
                        'saida'   =>  $datetime_chegada_segunda_dose->copy()->addMinutes(10),
                        'dose'   =>  Candidato::DOSE_ENUM[1],
                    ]);

                    $candidatoSegundaDose->save();

                }
                if($candidato->email != null || $candidato->email != ""  || $candidato->email != " "){
                    Notification::send($candidato, new CandidatoAprovado($candidato, $candidatoSegundaDose,$lote));
                    sleep(1);
                }


                return true;

            }

        }

        return false;

    }

    public function diasPorPosto($posto_id) {
        if ($posto_id != null) {
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

            return $horarios_agrupados_por_dia;
        }

        return null;
    }

    public function distribuirJob()
    {

        \Log::info("message");
        $this->dispatch(new DistribuirFila());
        return redirect()->back()->with(['mensagem' => 'Distribuição está sendo feita, verique o worker
        !', 'class' => 'success']);
    }

    public function distribuirVacina()
    {
        set_time_limit(3600);
        $postos = PostoVacinacao::all();
        $candidatos = Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[0])->whereIn('etapa_id', [4, 5])->oldest()->get();
        // $postos = Etapa::find($request->publico_id)->pontos;
        // $etapa = Etapa::find($request->publico_id);

        // foreach ($postos as $key1 => $posto) {

        //     if(!$etapa->lotes->count()){
        //         $postos->pull($key1);
        //         break;
        //     }
        //     foreach ($etapa->lotes as $key2 => $lote) {
        //         DB::table('lote_posto_vacinacao')->where("posto_vacinacao_id", $posto->id)->where('lote_id', $lote->id)->first();
        //         $qtdCandidato = DB::table('candidatos')->where("posto_vacinacao_id",$posto->id)->where('lote_id', $lote->id)->count();
        //         if(DB::table('lote_posto_vacinacao')->where("posto_vacinacao_id", $posto->id)->where('lote_id', $lote->id)->first() == null){
        //             $postos->pull($key1);
        //             continue;

        //         }
        //         $qtdVacina = DB::table('lote_posto_vacinacao')->where("posto_vacinacao_id", $posto->id)->where('lote_id', $lote->id)->first()->qtdVacina;
        //         if($qtdCandidato == $qtdVacina || $qtdVacina == $qtdCandidato + 1){
        //             $postos->pull($key1);

        //             continue;

        //         }

        //     }

        // }


        // $postos = array_values($postos->toArray());


        foreach ($candidatos as $key => $candidato) {

            foreach ($postos as $key => $posto) {
                $horarios_agrupados_por_dia = $this->diasPorPosto($posto->id);

                $resultado = $this->agendar($horarios_agrupados_por_dia, $candidato->id, $posto->id );

                if ($resultado) {
                    $aprovado = true;
                    Notification::send(User::all(), new CandidatoFilaArquivo($candidato));
                   break;
                }else{
                    continue;
                }


            }
        }
        try {
            // dd($aprovado);
            if ($aprovado) {
                return redirect()->back()->with(['mensagem' => 'Distribuição feita!', 'class' => 'success']);
            }else{
                return redirect()->back()->with(['mensagem' => 'Nenhum candidato foi aprovado!', 'class' => 'danger']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with(['mensagem' => $th->getMessage(), 'class' => 'danger']);
        }


    }

    public function painel()
    {

        return view('fila.fila_distribuir');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
