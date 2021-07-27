<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use PDF;
use App\Models\Candidato;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use Illuminate\Support\Carbon;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidato::query();
        $data = [];
        if ($request->data_inicio_check && $request->data_fim_check && $request->data_inicio != null && $request->data_fim != null) {
            $data_inicio = (new Carbon($request->data_inicio));
            $data_fim = (new Carbon($request->data_fim));
            $query->where([['created_at','>=',$data_inicio], ['created_at','<=', $data_fim]]);
        }
        
        if ($request->ponto_check && $request->ponto != null) {
            $pontos = PostoVacinacao::where('id',$request->ponto )->get();
        }else{
            $pontos = PostoVacinacao::where('status', '!=', 'arquivado')->get();
        }
        $data = [
            'pontos' => $pontos,
            'candidatos' => $query->get(),
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'request' => $request
        ];
        if($request->action == "export"){
            // dd($query->get());
            view()->share('pontos',$data);
            $pdf = PDF::loadView('relatorios.pdf', $data);
            $pdf->setPaper('A4', 'landscape');

            return $pdf->stream('test_pdf.pdf');
    
            // download PDF file with download method
            return $pdf->download('pdf_file.pdf');

        }else{

            return view('relatorios.index')->with(['candidato_enum' => Candidato::APROVACAO_ENUM,
                                            'tipos' => Etapa::TIPO_ENUM,
                                            'postos' => PostoVacinacao::where('status', '!=', 'arquivado')->get(),
                                            'pontos' => $pontos,
                                            'candidatos' => $query->get(),
                                            'doses' => Candidato::DOSE_ENUM,
                                            'publicos' => Etapa::orderBy('texto_home')->get(),
                                            'request' => $request]);
        }
    }

    
}
