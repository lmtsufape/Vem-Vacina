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
        try {
            Excel::import(new CandidatoImport, $file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();

             foreach ($failures as $failure) {
                 $failure->row(); // row that went wrong
                 $failure->attribute(); // either heading key (if using heading row concern) or column index
                 $failure->errors(); // Actual error messages from Laravel validator
                 $failure->values(); // The values of the row that has failed.
             }
        }



        return back()->with(['mensagem' => 'Solicitação realizada com sucesso!']);
    }
}
