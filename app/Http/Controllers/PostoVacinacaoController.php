<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\PostoVacinacao;
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
        $postos = PostoVacinacao::all();
        return view('postos.index', compact('postos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('postos.store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $posto = new PostoVacinacao();

        $posto->nome = $request->nome;
        $posto->endereco = $request->endereco;

        if ($request->para_idoso != null) {
            $posto->para_idoso = true;
        } else {
            $posto->para_profissional_da_saude = false;
        }

        if ($request->para_profissional_da_saude != null) {
            $posto->para_profissional_da_saude = true;
        } else {
            $posto->para_profissional_da_saude = false;
        }

        $posto->save();

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
        $posto = PostoVacinacao::findOrFail($id);
        return view('postos.edit', compact('posto'));
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
        $data = $request->all();
        $posto = PostoVacinacao::find($id);
        
        $posto->nome = $request->nome;
        $posto->endereco = $request->endereco;

        if ($request->para_idoso == "on") {
            $posto->para_idoso = true;
        } else {
            $posto->para_idoso = false;
        }

        if ($request->para_profissional_da_saude == "on") {
            $posto->para_profissional_da_saude = true;
        } else {
            $posto->para_profissional_da_saude = false;
        }
        
        $posto->update();
        
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
        $posto = PostoVacinacao::findOrFail($id);
        $posto->delete();

        return redirect()->route('postos.index')->with('message', 'Posto excluído com sucesso!');
    }

    public function todosOsPostos() {
        $postos = PostoVacinacao::all();

        return response()->json($postos);
    }
}
