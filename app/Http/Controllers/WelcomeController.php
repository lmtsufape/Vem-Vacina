<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\PostoVacinacao;
use App\Models\Configuracao;

class WelcomeController extends Controller
{
    public function index() {
        $quantPessoasCadastradas = 0;
        $quantPessoasPriDose = 0;
        $quantPessoasSegDose = 0;
        $vacinasDisponiveisNosPontos = 1;
        $config = Configuracao::first();

        $publicos = Etapa::orderBy('texto')->get();
        foreach ($publicos as $publico) {
            $quantPessoasPriDose += $publico->total_pessoas_vacinadas_pri_dose;
            $quantPessoasSegDose += $publico->total_pessoas_vacinadas_seg_dose;
        }

        $pontos = PostoVacinacao::all();
        // foreach ($pontos as $posto) {
        //     foreach ($posto->lotes as $key => $lote) {
        //         $vacinasDisponiveisNosPontos += $lote->pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote->pivot->id)->count();
        //     }
        // }

        $quantPessoasCadastradas = count(Candidato::all());

        return view('welcome')->with(['etapas'                  => $publicos,
                                      'quantPessoasCadastradas' => $quantPessoasCadastradas,
                                      'quantPessoasPriDose'     => $quantPessoasPriDose,
                                      'quantPessoasSegDose'     => $quantPessoasSegDose,
                                      'tipos'                   => Etapa::TIPO_ENUM,
                                      'vacinasDisponiveis'      => $vacinasDisponiveisNosPontos,
                                      'config'                  => $config,]);
    }
}
