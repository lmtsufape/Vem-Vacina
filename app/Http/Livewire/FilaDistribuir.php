<?php

namespace App\Http\Livewire;

use Exception;
use Throwable;
use DateInterval;
use Carbon\Carbon;
use App\Models\Lote;
use App\Models\User;
use App\Models\Etapa;
use Livewire\Component;
use Carbon\CarbonPeriod;
use App\Models\Candidato;
use App\Models\PostoVacinacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Notifications\CandidatoAprovado;
use App\Notifications\CandidatoFilaArquivo;
use Illuminate\Support\Facades\Notification;

class FilaDistribuir extends Component
{
    public $pontos;
    public $etapas;
    public $tipos;
    public $etapa_id;
    public $ponto_id;
    public $qtdFila;

    protected $rules = [
        'etapa_id' => 'required',
        'ponto_id' => 'required',
    ];
    protected $messages = [
        'etapa_id.required' => 'Selecione um público.',
        'ponto_id.required' => 'Selecione um ponto.',
    ];




    public function mount()
    {
        $this->pontos = PostoVacinacao::all();
        $this->etapas = Etapa::all();
        $this->tipos = Etapa::TIPO_ENUM;

    }

    public function quantidadeVacinaPorPonto($posto)
    {

        $soma = 0;

        foreach($posto->lotes as $key1 => $lote){
            if($lote->pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote->pivot->id)->count() > 0 && $lote->etapas->find($this->etapa_id)){

                $soma += $lote->pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote->pivot->id)->count();

            }
        }

        if($posto->lotes->first()->dose_unica == false){
            $soma = intval($soma/2) + 1;
        }
        return $soma;
    }



    public function distribuir()
    {
        $this->validate();
        Gate::authorize('distribuir-fila');
        set_time_limit(900);
        $posto = PostoVacinacao::find($this->ponto_id);

        $qtdVacinaPorPonto = $this->quantidadeVacinaPorPonto($posto);

        $candidatos = Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[0])->where('etapa_id', $this->etapa_id)->oldest()->take($qtdVacinaPorPonto)->get();

        $horarios_agrupados_por_dia = $this->diasPorPosto($posto);
        if (!$horarios_agrupados_por_dia || !count($horarios_agrupados_por_dia) ) {
            session()->flash('message', 'Acabaram os horários.');
            return;
        }
        try {


            $aprovado = false;
            $contadorParada = 0;
            foreach ($candidatos as $key => $candidato) {
                    $resultado = $this->agendar($horarios_agrupados_por_dia, $candidato, $posto );


                    if ($resultado) {
                        Log::info($key);
                        $aprovado = true;
                        continue;
                    }else{
                        $contadorParada++;
                        if($contadorParada > 20){
                            session()->flash('message', 'Distribuição concluída com sucesso, as vacinas ou os horários acabaram.');
                            return;
                        }
                        continue;
                    }
            }

            if ($aprovado) {
                session()->flash('message', 'Distribuição concluída com sucesso.');
                return;
            }else{
                session()->flash('message', 'Ninguém foi distribuído.');
                return;

            }

        } catch (Throwable $th) {
            //throw $th;
            session()->flash('message',  $th->getMessage());
            return;
        } catch (Exception $e) {
            session()->flash('message',  $e->getMessage());
            return ;
        }
        session()->flash('message', 'Distribuição finalizada.');
        return;

    }

    public function agendar($horarios_agrupados_por_dia, $candidato, $posto) {

        // var_dump($horarios_agrupados_por_dia);
        foreach ($horarios_agrupados_por_dia as $key1 => $dia) {

            foreach ($dia as $key2 => $horario) {

                $dia_vacinacao          = date('d/m/Y', strtotime($horario));
                $horario_vacinacao      = date('H:i', strtotime($horario));
                $id_posto               = $posto->id;
                $datetime_chegada       = Carbon::createFromFormat("d/m/Y H:i", $dia_vacinacao . " " . $horario_vacinacao);
                $datetime_saida         = $datetime_chegada->copy()->addMinutes(10);

                $candidatos_no_mesmo_horario_no_mesmo_lugar = Candidato::where("chegada", "=", $datetime_chegada)->where("posto_vacinacao_id", $id_posto)->get();

                if ($candidatos_no_mesmo_horario_no_mesmo_lugar->count() > 0) {
                    continue;
                }

                if (Candidato::where('cpf',$candidato->cpf)->whereIn('aprovacao', [Candidato::APROVACAO_ENUM[1],Candidato::APROVACAO_ENUM[3]])
                ->count() > 0) {
                    //\Log::info("cpf");
                    break 2;
                }

                $etapa = $candidato->etapa;

                if(!$etapa->lotes->count()){
                    break 2;
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
                                break 3;
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
                    session()->flash('message', 'Acabaram as vacinas.');
                    break 2;
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
                }


                return true;

            }

        }

        return false;

    }

    public function diasPorPosto($posto) {
        if ($posto != null) {
            // Cria uma lista de possiveis horarios do proximo dia quando o posto abre
            // até a proxima semana, removendo os final de semanas

            $todos_os_horarios_por_dia = [];
            $todos_os_horarios = [];

            // $posto = PostoVacinacao::find($posto_id);

            // Pega os proximos 7 dias
            for($i = 0; $i < 7; $i++) {
                $dia = Carbon::today()->addDay($i);

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
            }

            // Os periodos são salvos como horarios[dia][janela]
            // Esse loop planificado o array pra horarios[janela]
            foreach($todos_os_horarios_por_dia as $dia) {
                foreach($dia as $janela) {
                    array_push($todos_os_horarios, $janela);
                }
            }

            // Pega os candidatos do posto selecionado cuja data de vacinação é de amanhã pra frente, os que já passaram não importam
            $candidatos = Candidato::where("posto_vacinacao_id", $posto->id)->whereDate('chegada', '>=', Carbon::tomorrow()->toDateString())->where('aprovacao', Candidato::APROVACAO_ENUM[1])->get();

            $horarios_disponiveis = array_diff($todos_os_horarios, $candidatos->pluck('chegada')->toArray());

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

    public function render()
    {
        Gate::authorize('distribuir-fila');
        return view('livewire.fila-distribuir');
    }
}
