<?php

namespace App\Http\Controllers;

use App\Imports\CandidatoImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function show()
    {

    }

    public function store(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new CandidatoImport, $file);

        return back()->with(['status' => 'Solicitação realizada com sucesso!']);
    }
}
