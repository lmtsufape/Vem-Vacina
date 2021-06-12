<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\PostoVacinacao;
use App\Models\Configuracao;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index() {
        // $quantPessoasCadastradas = 0;
        // $quantPessoasPriDose = 0;
        // $quantPessoasSegDose = 0;
        $config = Configuracao::first();
        // set_time_limit(360);
        // $publicos = Etapa::with('candidatos')->orderBy('texto')->get();
        // $pontos = PostoVacinacao::all();
        // $ultimaAtualizacao = null;
        // $seconds = now()->addDays(1);
        // // dd($publicos);
        // // $seconds = now()->addMinutes(3);
        // // $quant_aprovada = intval(count($publico->candidatos()->where('aprovacao', '!=', $aprovacao_enum[0])->get())/2);
        // // $quant_espera = count($publico->candidatos()->where('aprovacao', $aprovacao_enum[0])->get());
        // $ultimaAtualizacao      = Cache::remember('ultimaAtualizacao', $seconds, function () {
        //                             return now();
        //                         });
        // $ultimaAtualizacao      = Cache::remember('ultimaAtualizacao', $seconds, function () {
        //                             return now();
        //                         });
        // $ultimaAtualizacao      = Cache::remember('ultimaAtualizacao', $seconds, function () {
        //                             return now();
        //                         });

        // $quantPessoasPriDose      = Cache::remember('quantPessoasPriDose', $seconds, function () use($publicos) {
        //                                 $quantPessoasPriDose = 0;
        //                                 foreach ($publicos as $publico) {
        //                                     $quantPessoasPriDose += $publico->total_pessoas_vacinadas_pri_dose;
        //                                 }
        //                                 return $quantPessoasPriDose;
        //                             });
        // $quantPessoasSegDose      = Cache::remember('quantPessoasSegDose', $seconds, function () use($publicos) {
        //                                 $quantPessoasSegDose = 0;
        //                                 foreach ($publicos as $publico) {
        //                                     $quantPessoasSegDose += $publico->total_pessoas_vacinadas_seg_dose;
        //                                 }
        //                                 return $quantPessoasSegDose;
        //                             });

        // $candidatosVacinados     = Cache::remember('candidatosVacinados', $seconds, function () use($pontos) {
        //                                 return Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[3])->get();
        //                             });
        // $quantPessoasCadastradas    = Cache::remember('vacinasDisponiveis', $seconds, function () use($pontos) {
        //                                 return intval(count(Candidato::where('aprovacao', '!=', Candidato::APROVACAO_ENUM[0])->get())/2) + count(Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[0])->get());
        //                             });
        // $vacinasDisponiveis      = Cache::remember('vacinasDisponiveis', $seconds, function () use($pontos) {
        //                                 return $this->quantVacinasDisponiveis($pontos);
        //                             });
        // $porcentagemVacinada      = Cache::remember('porcentagemVacinada', $seconds, function () use($quantPessoasPriDose) {
        //                                 return $this->porcentagemVacinada($quantPessoasPriDose);
        //                             });
        // $quantVacinadosPorBairro      = Cache::remember('quantVacinadosPorBairro', $seconds, function () use($candidatosVacinados) {
        //                                 return $this->quantVacinadosPorBairro($candidatosVacinados);
        //                             });
        // $quantVacinadosPorIdade     = Cache::remember('quantVacinadosPorIdade', $seconds, function () use($candidatosVacinados) {
        //                                 return $this->quantVacinadosPorIdade($candidatosVacinados);
        //                             });
        // $vacinadosPorSexo      = Cache::remember('vacinadosPorSexo', $seconds, function () use($candidatosVacinados) {
        //                                 return $this->vacinadosPorSexo($candidatosVacinados);
        //                             });

        return view('welcome2', compact('config'));
        // return view('welcome2')->with(['publicos'                => $publicos,
        //                               'quantPessoasCadastradas' => $quantPessoasCadastradas,
        //                               'quantPessoasPriDose'     => $quantPessoasPriDose,
        //                               'quantPessoasSegDose'     => $quantPessoasSegDose,
        //                               'aprovacao_enum'          => Candidato::APROVACAO_ENUM,
        //                               'vacinasDisponiveis'      => $vacinasDisponiveis,
        //                               'porcentagemVacinada'     => $porcentagemVacinada,
        //                               'quantVacinadosPorBairro' => $quantVacinadosPorBairro,
        //                               'quantVacinadosPorIdade'  => $quantVacinadosPorIdade,
        //                               'vacinadosPorSexo'        => $vacinadosPorSexo,
        //                               'config'                  => $config,
        //                               'ultimaAtt'               => $ultimaAtualizacao]);
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

    public function porcentagemVacinada($quantia) {
        // $quantidade = count($candidatosVacinados);
        return ($quantia * 100) / 140570;
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

    public function baixarAnexo($name)
    {
        $file = public_path()."/anexo/".$name;
        $headers = array('Content-Type: application/pdf',);
        return Response::download($file, 'anexo_comordidade.pdf',$headers);
    }

    public function sobre() {
        return view('sobre');
    }
}
