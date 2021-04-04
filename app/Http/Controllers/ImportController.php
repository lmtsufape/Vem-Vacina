<?php

namespace App\Http\Controllers;

use App\Imports\CandidatoImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Candidato;
use Carbon\Carbon;
use App\Models\Etapa;

class ImportController extends Controller
{
    public function show()
    {

    }

    public function store(Request $request)
    {
        // $file = $request->file('file');
        // dd($request);
        $validate = $request->validate([
            'agendamentos' => 'required|file',
        ]);

        $file_handle = fopen($request->agendamentos, 'r');
        $line_of_text = collect();
        while (!feof($file_handle)) {
            $line_of_text->push(fgetcsv($file_handle, 0, ','));
        }
        fclose($file_handle);
        // dd($line_of_text);

        $hoje = Carbon::today();
        foreach($line_of_text as $i => $line) {
            $existe = Candidato::where('cpf', $line[4])->first();
            if ($i != 0 && $existe == null) {
                $candidato = new Candidato;
                
                $candidato->nome_completo = $line[2];
                $candidato->data_de_nascimento = new Carbon($line[3]);
                $candidato->cpf     = $line[4];
                $candidato->numero_cartao_sus = $line[5];
                $candidato->sexo = $line[6];
                $candidato->nome_da_mae = $line[7];
                $candidato->telefone = $line[8];
                $candidato->whatsapp = $line[9];
                $candidato->email = $line[10];
                $candidato->logradouro = $line[11];
                $candidato->numero_residencia = $line[12];
                $candidato->bairro = $line[13];
                $candidato->cep    = $line[14]; 
                $candidato->aprovacao = Candidato::APROVACAO_ENUM[0];
                $candidato->dose = Candidato::DOSE_ENUM[0];
                $candidato->cidade = "Garanhuns";
                $idade = $hoje->diffInYears(new Carbon($line[3]));
                $candidato->idade = $idade;

                $etapa = Etapa::where([['tipo', Etapa::TIPO_ENUM[0]], ['inicio_intervalo', '<=', $idade], ['fim_intervalo', '>=', $idade]])->first();
                
                if ($etapa == null) {
                    return redirect()->back()->withErrors([
                        "agendamentos" => $line[2] . " com CPF " . $line[4] . " não se encaixa em nenhum público cadastrado."
                    ])->withInput();
                }
                $candidato->etapa_id = $etapa->id;
                $candidato->save();

                if ($line[15] == "Sim") {
                    if ($etapa->outrasInfo != null && count($etapa->outrasInfo) > 0) {
                        $candidato->outrasInfo()->attach($etapa->outrasInfo[0]->id);
                    }
                }
                $candidato->update();
            }
        }
        // try {
        //     Excel::import(new CandidatoImport, $file);
        // } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        //      $failures = $e->failures();

        //      foreach ($failures as $failure) {
        //          $failure->row(); // row that went wrong
        //          $failure->attribute(); // either heading key (if using heading row concern) or column index
        //          $failure->errors(); // Actual error messages from Laravel validator
        //          $failure->values(); // The values of the row that has failed.
        //      }
        // }



        return redirect()->route('fila.index')->with(['mensagem' => 'Importação feita com sucesso!', 'class'=>'success']);
    }
}
