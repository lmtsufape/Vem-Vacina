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
use App\Http\Traits\HorariosAgrupadosPorDia;

class FilaDistribuir extends Component
{
    use HorariosAgrupadosPorDia {
        horarios as protected traitHorarios;
    }
    public $pontos;
    public $postos;
    public $etapas;
    public $tipos;
    public $etapa_id;
    public $ponto_id;
    public $qtdFila;
    public $cpf;
    public $bool;

    protected $rules = [
        'etapa_id' => 'required',
        'ponto_id' => 'required',
        'qtdFila' => 'required',
    ];
    protected $messages = [
        'etapa_id.required' => 'Selecione um público.',
        'ponto_id.required' => 'Selecione um ponto.',
        'qtdFila.required' => 'Coloque uma quantidade.',
    ];




    public function mount()
    {
        $this->pontos = PostoVacinacao::orderBy('nome')->get();
        $this->postos = $this->pontos;
        $this->etapas = Etapa::orderBy('texto_home')->get();
        $this->tipos = Etapa::TIPO_ENUM;
        $this->bool = false;

    }

    public function quantidadeVacinaPorPonto($posto)
    {

        $soma = 0;

        foreach($posto->lotes as $key1 => $lote){
            if($lote->pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote->pivot->id)->count() > 0 && $lote->etapas->find($this->etapa_id)){

                $soma += $lote->pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote->pivot->id)->count();

            }
        }

        // if($posto->lotes->first()->dose_unica == false){
        //     $soma = intval($soma/2) + 1;
        // }
        return $soma;
    }



    public function distribuir()
    {
        $this->reset(['bool']);
        $this->validate();
        Gate::authorize('distribuir-fila');
        set_time_limit(900);
        $posto = PostoVacinacao::find($this->ponto_id);

        $qtdVacinaPorPonto = $this->quantidadeVacinaPorPonto($posto);
        if ($this->qtdFila == null) {
            $this->qtdFila = $qtdVacinaPorPonto;
        }
        // dd($this->cpf);
        if ($this->cpf != null) {
            $candidatos = Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[0])->where('etapa_id', $this->etapa_id)->where('cpf', $this->cpf)->get();
        }else{
            $candidatos = Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[0])->where('etapa_id', $this->etapa_id)->oldest()->take($this->qtdFila)->get();

        }


        $horarios_agrupados_por_dia = $this->traitHorarios($posto->id);

        if (!$horarios_agrupados_por_dia || !count($horarios_agrupados_por_dia) ) {
            session()->flash('message', 'Acabaram os horários.');
            return;
        }
        try {

            Log::info($qtdVacinaPorPonto);
            Log::info($candidatos->count());
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
                        if($contadorParada > 80){
                            session()->flash('message', 'Distribuição concluída com sucesso, as vacinas ou os horários acabaram.');
                            return;
                        }
                        continue;
                    }
            }
            $this->reset('cpf');
            \Log::info("acabou");
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

                // $candidatos_no_mesmo_horario_no_mesmo_lugar = Candidato::where("chegada", "=", $datetime_chegada)->where("posto_vacinacao_id", $id_posto)->get();

                // if ($candidatos_no_mesmo_horario_no_mesmo_lugar->count() > 0) {
                //     continue;
                // }

                if (Candidato::where('cpf',$candidato->cpf)->whereIn('aprovacao', [Candidato::APROVACAO_ENUM[1],Candidato::APROVACAO_ENUM[3]])
                ->count() > 0) {
                    \Log::info("1");
                    break 2;
                }

                $etapa = $candidato->etapa;

                if(!$etapa->lotes->count()){
                    \Log::info("2");
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
                                \Log::info("3");
                                break 3;
                            }
                            \Log::info("4");
                            break;
                        }

                    }else{
                        //Se o lote disponivel for de vacina com dose unica vai parar aqui
                        //e verifica se tem pelo menos uma ou mais vacinas disponiveis
                        if ($qtdCandidato < $lote->qtdVacina) {
                            $id_lote = $lote->id;
                            $chave_estrangeiro_lote = $lote->lote_id;
                            $candidato->dose = "Dose única";
                            \Log::info("5");
                            break;
                        }
                    }

                }

                if ($id_lote == 0) { // Se é 0 é porque não tem vacinas...
                    session()->flash('message', 'Acabaram as vacinas.');
                    \Log::info("6");
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
                $candidatoSegundaDose = null;
                if (!$lote->dose_unica) {
                    \Log::info("candidato segundo");
                    $datetime_chegada_segunda_dose = $candidato->chegada->add(new DateInterval('P'.$lote->inicio_periodo.'D'));
                    if($datetime_chegada_segunda_dose->format('l') == "Sunday" || $datetime_chegada_segunda_dose->format('l') == "Saturday"){
                        $datetime_chegada_segunda_dose->add(new DateInterval('P3D'));
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
                $posto->dias->where('dia', $datetime_chegada->copy()->startOfDay())->first()->horarios->where('horario', $datetime_chegada)->first()->delete();
                $posto->refresh();

                unset($dia[$key2]);
                \Log::info("true");
                return true;

            }
            unset($horarios_agrupados_por_dia[$key1]);
        }
        \Log::info("false");
        return false;

    }

    public function render()
    {
        Gate::authorize('distribuir-fila');
        return view('livewire.fila-distribuir');
    }
}
