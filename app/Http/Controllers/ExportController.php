<?php

namespace App\Http\Controllers;

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
        $candidatos = Candidato::all()->count();
        $lotes = Lote::all()->count();
        $postos = PostoVacinacao::all();
        $qtd_postos = $postos->count();
        return view('export.index', compact('candidatos', 'lotes', 'qtd_postos', 'postos'));
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

    public function listarCandidato()
    {
        return view('export.candidatos', [
            'candidatos' => Candidato::all(),
            'tipos' => Etapa::TIPO_ENUM
        ]);
    }

    public function agendamentosDoPosto($id) {
        dd($id);
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
