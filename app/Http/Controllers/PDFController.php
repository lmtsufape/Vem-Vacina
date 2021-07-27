<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;

class PDFController extends Controller
{
    
    public function gerarPdf(Request $request, $bool = 0)
    {
       
        if ($request->ponto_check && $request->ponto != null) {
            $data = PostoVacinacao::where('id',$request->ponto )->get();
        }else{
            $data = PostoVacinacao::all();
        }

        view()->share('pontos',$data);
        $pdf = PDF::loadView('relatorios.pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('test_pdf.pdf');
        // download PDF file with download method
        // return $pdf->download('pdf_file.pdf');
    }
    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

   
}
