<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lote;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Exports\LoteExport;
use App\Exports\PostoExport;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use App\Exports\CandidatoExport;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostoCandidatoExport;
use App\Exports\CandidatosPostoExport;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('ver-export');
        $candidatos = Candidato::withTrashed()->count();
        $lotes = Lote::all()->count();
        $postos = PostoVacinacao::all();
        $qtd_postos = $postos->count();
        $hoje = Carbon::now()->format("Y-m-d");
        $tomorrow = Carbon::now()->addDay()->format("Y-m-d");
        return view('export.index', compact('candidatos', 'lotes', 'qtd_postos', 'postos', 'hoje', 'tomorrow'));
    }

    public function exportCandidato()
    {
        Gate::authorize('baixar-export');
        return Excel::download(new CandidatoExport, 'candidatos.xlsx');
    }

    public function exportLote()
    {
        Gate::authorize('baixar-export');
        return Excel::download(new LoteExport, 'lotes.xlsx');
    }

    public function exportPosto()
    {
        Gate::authorize('baixar-export');
        return Excel::download(new PostoExport, 'postos.xlsx');
    }

    public function exportPostoCandidato(Request $request)
    {
        Gate::authorize('baixar-export');
        $candidatos = null;
        // dd($request->all());
        $query = Candidato::query();

        if ($request->tipo == "Não Analisado") {
            $query = $query->where('aprovacao', Candidato::APROVACAO_ENUM[0]);
        }else if ($request->tipo == "Aprovado") {
            $query = $query->where('aprovacao', Candidato::APROVACAO_ENUM[1]);
        }else if ($request->tipo == "Reprovado") {
            $query = $query->onlyTrashed()->where('aprovacao', Candidato::APROVACAO_ENUM[2]);
        }else if ($request->tipo == "Vacinado") {
            $query = $query->where('aprovacao', Candidato::APROVACAO_ENUM[3]);
        }else{
            $query = $query->where('aprovacao', Candidato::APROVACAO_ENUM[1]);
        }

        if ($request->nome_check && $request->nome != null) {
            $query->where('nome_completo', 'ilike', '%' . $request->nome . '%');
        }

        if ($request->ponto_check && $request->ponto != null) {
            $query->where('posto_vacinacao_id', $request->ponto);
        }

        if ($request->cpf_check && $request->cpf != null) {
            $query->where('cpf', 'ilike', '%'.$request->cpf.'%');
        }
        if ($request->data_vacinado_check && $request->data_vacinado != null) {
            $amanha = (new Carbon($request->data_vacinado))->addDays(1);
            $hoje = (new Carbon($request->data_vacinado));
            $query->where([['updated_at','>=',$hoje], ['updated_at','<=', $amanha]]);
        }
        if ($request->mes_check && $request->mes != null) {
            $mes0 = (new Carbon($request->mes))->format('m');
            $query->whereMonth('chegada',$mes0);
        }
        if ($request->data_check && $request->data != null) {
            $amanha = (new Carbon($request->data))->addDays(1);
            $hoje = (new Carbon($request->data));
            $query->where([['chegada','>=',$hoje], ['chegada','<=', $amanha]]);
        }

        if ($request->dose_check && $request->dose != null) {
            $query->where('dose',$request->dose);
        }

        if ($request->aprovado) {
            $query->where('aprovacao', Candidato::APROVACAO_ENUM[1]);
        }

        if ($request->duplicado) {
            $query->where('cpf', Candidato::APROVACAO_ENUM[0]);
        }

        if ($request->publico_check) {
            if ($request->publico != null) {
                $query->where('etapa_id', $request->publico);
            }
        }

        if ($request->sus_check) {
            if ($request->sus) {
                $query->where('numero_cartao_sus', 'ilike', '%'.$request->sus.'%');
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
            $agendamentos = $query->take(1000)->get();
        } else {
            if($request->posicao_check) {

                $agendamentos = $query->oldest()->take(1000)->get();
            }else{
                $agendamentos = $query->take(1000)->get();
            }
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
        $hoje = Carbon::now()->format("Y-m-d");
        $tomorrow = Carbon::now()->addDay()->format("Y-m-d");
        return view('export.index')->with(['candidatos' => $agendamentos,
                                        'candidato_enum' => Candidato::APROVACAO_ENUM,
                                        'tipos' => Etapa::TIPO_ENUM,
                                        'postos' => PostoVacinacao::all(),
                                        'doses' => Candidato::DOSE_ENUM,
                                        'publicos' => Etapa::orderBy('texto_home')->get(),
                                        'hoje' => $hoje,
                                        'tomorrow' => $tomorrow,
                                        'request' => $request]);
    }

    public function gerar(Request $request)
    {
        // dd( array_column(json_decode($request->candidatos), 'id')  );
        $ids = array_column(json_decode($request->candidatos), 'id');
        $nome_arquivo = $request->nome_arquivo ? $request->nome_arquivo : 'agendamentos.xlsx';
        $caraceteres = array("-", "/", ".", "*", "@", "$", "%", "&", ")", "(");
        $nome_arquivo = str_replace($caraceteres, "", $nome_arquivo);
        $candidatos = Candidato::withTrashed()->whereIn('id', $ids)->take(1000)->get();
        return Excel::download(new PostoCandidatoExport( $candidatos), $nome_arquivo.'.xlsx' );
    }
    public function listarCandidato()
    {
        return view('export.candidatos', [
            'candidatos' => Candidato::all(),
            'tipos' => Etapa::TIPO_ENUM
        ]);
    }

    public function agendamentosDoPosto($id) {
        $posto = PostoVacinacao::find($id);
        return Excel::download(new CandidatosPostoExport($posto), $posto->nome.'.xlsx');
    }


    public function store(Request $request)
    {

    }


    public function show($id)
    {

    }


    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }


}
