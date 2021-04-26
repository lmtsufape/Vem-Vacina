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
        $config = Configuracao::first();

        $publicos = Etapa::orderBy('texto')->get();
        $pontos = PostoVacinacao::all();

        foreach ($publicos as $publico) {
            $quantPessoasPriDose += $publico->total_pessoas_vacinadas_pri_dose;
            $quantPessoasSegDose += $publico->total_pessoas_vacinadas_seg_dose;
        }

        $candidatosVacinados = Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[3])->get();

        $quantPessoasCadastradas = intval(count(Candidato::where('aprovacao', '!=', Candidato::APROVACAO_ENUM[0])->get())/2) + count(Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[0])->get());


        return view('welcome')->with(['publicos'                => $publicos,
                                      'quantPessoasCadastradas' => $quantPessoasCadastradas,
                                      'quantPessoasPriDose'     => $quantPessoasPriDose,
                                      'quantPessoasSegDose'     => $quantPessoasSegDose,
                                      'aprovacao_enum'          => Candidato::APROVACAO_ENUM,
                                      'vacinasDisponiveis'      => $this->quantVacinasDisponiveis($pontos),
                                      'porcentagemVacinada'     => $this->porcentagemVacinada($candidatosVacinados),
                                      'quantVacinadosPorBairro' => $this->quantVacinadosPorBairro($candidatosVacinados),
                                      'quantVacinadosPorIdade'  => $this->quantVacinadosPorIdade($candidatosVacinados),
                                      'vacinadosPorSexo'        => $this->vacinadosPorSexo($candidatosVacinados),   
                                      'config'                  => $config,]);
    }

    public function quantVacinasDisponiveis($pontos) {
        $vacinasDisponiveisNosPontos = 0;
        foreach ($pontos as $posto) {
            foreach ($posto->lotes as $key => $lote) {
                $vacinasDisponiveisNosPontos += $lote->pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote->pivot->id)->count();
            }
        }

        return $vacinasDisponiveisNosPontos;
    }

    public function porcentagemVacinada($candidatosVacinados) {
        $quantidade = count($candidatosVacinados);
        return ($quantidade * 100) / 140570;
    }

    public function quantVacinadosPorBairro($candidatosVacinados) {
        $bairrosMaisVacinados = collect();
        
        foreach ($candidatosVacinados->groupBy('bairro') as $bairro) {
            if (!($bairrosMaisVacinados->contains('bairro', $bairro[0]->bairro))) {
                $bairrosMaisVacinados->push(['bairro' => $bairro[0]->bairro, 'quantidade' => count($bairro)]);
            } 
        }

        return $bairrosMaisVacinados->sortByDesc('quantidade');
    }

    public function quantVacinadosPorIdade($candidatosVacinados) {
        $vacinadosPorIdade = collect();
        $candidatos = Candidato::all();
        
        foreach ($candidatosVacinados->groupBy('idade') as $idade) {
            $quantidade = count($candidatos->groupBy('idade')->get($idade[0]->idade));
            if (!($vacinadosPorIdade->contains('idade', $idade[0]->idade))) {
                if ($quantidade > 0) {
                    $vacinadosPorIdade->push(['idade' => $idade[0]->idade, 'porcentagem' => (count($idade) * 100) / $quantidade]);
                } else {
                    $vacinadosPorIdade->push(['idade' => $idade[0]->idade, 'porcentagem' => 0]);
                }
            } 
        }
        return $vacinadosPorIdade->sortBy('idade');
    }

    public function vacinadosPorSexo($candidatosVacinados) {
        $vacinadosPorSexo = collect();
        
        foreach ($candidatosVacinados->groupBy('sexo') as $sexo) {
            if (!($vacinadosPorSexo->contains('sexo', $sexo[0]->sexo))) {
                $vacinadosPorSexo->push(['sexo' => $sexo[0]->sexo, 'quantidade' => count($sexo)]);
            }
        }
        return $vacinadosPorSexo->sortBy('sexo');
    }
}
