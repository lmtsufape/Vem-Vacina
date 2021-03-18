<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\Candidato;

class PostoVacinacaoController extends Controller
{
    public function horarios($posto_id) {
        // Cria uma lista de possiveis horarios do proximo dia quando o posto abre
        // até a proxima semana, removendo os final de semanas

        $todos_os_horarios_por_dia = [];
        $todos_os_horarios = [];
        
        // Pega os proximos 7 dias
        for($i = 0; $i < 7; $i++) {
            $dia = Carbon::tomorrow()->addDay($i);
            
            if($dia->isWeekend()) {
                // Não adiciona finais de semana
                continue;
            }

            // O dia começa as 09:00
            $inicio_do_dia = $dia->copy()->addHours(9);

            // O dia encerra as 16:00
            $fim_do_dia = $dia->copy()->addHours(16);

            // Cria uma lista de intervalos de 10 min
            $periodos_do_dia = CarbonPeriod::create($inicio_do_dia, '10 minutes', $fim_do_dia);

            // Salva os periodos
            array_push($todos_os_horarios_por_dia, $periodos_do_dia);
        }

        // Os periodos são salvos como horarios[dia][janela]
        // Esse loop planificado o array pra horarios[janela]
        foreach($todos_os_horarios_por_dia as $dia) {
            foreach($dia as $janela) {
                array_push($todos_os_horarios, $janela);
            }
        }

        // Pega os candidatos do posto selecionado cuja data de vacinação é de amanhã pra frente, os que já passaram não importam
        $candidatos = Candidato::where("posto_vacinacao_ìd", $posto_id)->whereDate('chegada', '>=', Carbon::tomorrow()->toDateString())->get();

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
            $inicio_do_dia = $h->copy()->startOfDay()->toDateString();
            if(!isset($horarios_agrupados_por_dia[$inicio_do_dia])) {
                $horarios_agrupados_por_dia[$inicio_do_dia] = [];
            }
            array_push($horarios_agrupados_por_dia[$inicio_do_dia], $h);
        }

        // return $horarios_agrupados_por_dia;
        return view('seletor_horario_form', ["horarios_por_dia" => $horarios_agrupados_por_dia]);
    }
}
