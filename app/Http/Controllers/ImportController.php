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

        if($request->agendamentos->getClientOriginalExtension() != "csv") {
            return redirect()->back()->withErrors(['agendamentos' => 'O campo agendamentos deve conter um arquivo do tipo: csv.']);
        }

        $file_handle = fopen($request->agendamentos, 'r');
        $line_of_text = collect();
        while (!feof($file_handle)) {
            $line_of_text->push(fgetcsv($file_handle, 0, ','));
        }
        fclose($file_handle);
        // dd($line_of_text);

        $hoje = Carbon::today();
        foreach($line_of_text as $i => $line) {
            if (is_array($line)) {
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

    public function storeVacinados(Request $request) {
        $validate = $request->validate([
            'vacinados' => 'required|file',
        ]);

        if($request->vacinados->getClientOriginalExtension() != "csv") {
            return redirect()->back()->withErrors(['vacinados' => 'O campo vacinados deve conter um arquivo do tipo: csv.']);
        }

        $file_handle = fopen($request->vacinados, 'r');
        $line_of_text = collect();
        while (!feof($file_handle)) {
            $line_of_text->push(fgetcsv($file_handle, 0, ','));
        }
        fclose($file_handle);

        foreach ($line_of_text as $i => $line) {
            if ($i != 0) {
                $candidato = null;
                if (is_array($line)) {
                    if ($line[11] == "D1") {
                        $candidato = Candidato::where([['cpf', $line[3]], ['dose', Candidato::DOSE_ENUM[0]]])->first();
                    } else if ($line[11] == "D2") {
                        $candidato = Candidato::where([['cpf', $line[3]], ['dose', Candidato::DOSE_ENUM[1]]])->first();
                    }
                }

                if ($candidato != null) {
                    if ($candidato->aprovacao != Candidato::APROVACAO_ENUM[3]) {
                        $candidato->aprovacao = Candidato::APROVACAO_ENUM[3];
                        $candidato->update();

                        if ($candidato->dose == Candidato::DOSE_ENUM[0]) {
                            $publico = $candidato->etapa;
                            $publico->total_pessoas_vacinadas_pri_dose += 1;
                            $publico->update();

                        } else if ($candidato->dose == Candidato::DOSE_ENUM[1]) {
                            $publico = $candidato->etapa;
                            $publico->total_pessoas_vacinadas_seg_dose += 1;
                            $publico->update();

                        }

                    }
                }
            }
        }

        return redirect()->route('dashboard')->with(['mensagem' => 'Importação do vacinados feita com sucesso!', 'class'=>'success']);
    }
}
