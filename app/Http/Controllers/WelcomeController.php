<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Candidato;

class WelcomeController extends Controller
{
    public function index() {
        $etapaAtual = null;
        $quantPessoasCadastradas = 0;

        $total = Etapa::where([['atual', true], ['tipo', Etapa::TIPO_ENUM[3]]])->first();
        $quantPessoasPriDose = $total->total_pessoas_vacinadas_pri_dose;
        $quantPessoasSegDose = $total->total_pessoas_vacinadas_seg_dose;

        $etapasAtuais = Etapa::where([['atual', true], ['tipo', '!=', Etapa::TIPO_ENUM[3]]])->get();
        
        // if ($etapasAtuais != null) {
        //     foreach ($etapas as $etapa) {
        //         $quantPessoasPriDose += $etapa->total_pessoas_vacinadas_pri_dose;
        //         $quantPessoasSegDose += $etapa->total_pessoas_vacinadas_seg_dose;
        //         // if ($etapa->tipo == Etapa::TIPO_ENUM[2]) {
        //         //     dd($etapa->opcoes()->orderBy('opcao')->get());
        //         // }
        //     }
        // }

        $quantPessoasCadastradas = count(Candidato::all());

        return view('welcome')->with(['etapas'                   => $etapasAtuais,
                                      'quantPessoasCadastradas' => $quantPessoasCadastradas,
                                      'quantPessoasPriDose'     => $quantPessoasPriDose,
                                      'quantPessoasSegDose'     => $quantPessoasSegDose,
                                      'doses'                   => Candidato::DOSE_ENUM,
                                      'tipos'                   => Etapa::TIPO_ENUM,]);
    }
}
