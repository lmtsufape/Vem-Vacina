<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index() {

        $config = Configuracao::first();
    
        return view('welcome')->with(['config'=> $config,]);
    }
    public function manutencao() {

    
        return view('manutencao');
    }

    public function estatisticas()
    {
        $config = Configuracao::first();
        set_time_limit(360);
        $publicos = Etapa::orderBy('texto')->get();
        $pontos = PostoVacinacao::all();
        $ultimaAtualizacao = null;
        // $seconds = now()->addMinutes(1);
        // $seconds = now()->add(new DateInterval('PT1M'));
        $seconds = now()->addDays(5);

        $ultimaAtualizacao      = Cache::remember('ultimaAtualizacao', $seconds, function () {
                                    return now();
                                });

        \Log::info("Inicio");
        $total['quantPessoasPriDose']       = Cache::remember('quantPessoasPriDose', $seconds, function () {
                                                \Log::info("quantPessoasPriDose");
                                                return DB::table('candidatos')->where('dose', "1ª Dose")->count();
                                            });
        $quantPessoasPriDose                = $total['quantPessoasPriDose'];
        
        $total['quantPessoasSegDose']       = Cache::remember('quantPessoasSegDose', $seconds, function () {
                                                
                                                return DB::table('candidatos')->where('dose', "2ª Dose")->count();
                                            });
        $total['quantPessoasDoseUnica']     = Cache::remember('quantPessoasDoseUnica', $seconds, function () {
                                                return DB::table('candidatos')->where('dose', "Dose única")->count();
                                            });
        $total['candidatosVacinados']       = Cache::remember('candidatosVacinados', $seconds, function () use($pontos) {
                                                return DB::table('candidatos')->where('aprovacao', Candidato::APROVACAO_ENUM[3])->get();
                                            });
        $candidatosVacinados                = $total['candidatosVacinados'];
        $total['quantPessoasCadastradas']   = Cache::remember('quantPessoasCadastradas', $seconds, function () use($pontos) {
                                                \Log::info("quantPessoasCadastradas");
                                                return DB::table('candidatos')->where('aprovacao', '!=',Candidato::APROVACAO_ENUM[2])->count();
                                            });
        // $total['porcentagemVacinada']       = Cache::remember('porcentagemVacinada', $seconds, function () use($quantPessoasPriDose) {
                                                
        //                                         return $this->porcentagemVacinada($quantPessoasPriDose);
        //                                     });
        // $total['quantVacinadosPorBairro']   = Cache::remember('quantVacinadosPorBairro', $seconds, function () use($candidatosVacinados) {
                                                
        //                                         return $this->quantVacinadosPorBairro($candidatosVacinados);
        //                                     });
        // $total['quantVacinadosPorIdade']    = Cache::remember('quantVacinadosPorIdade', $seconds, function () use($candidatosVacinados) {
                                                
        //                                         return $this->quantVacinadosPorIdade($candidatosVacinados);
        //                                     });
        // $total['vacinadosPorSexo']          = Cache::remember('vacinadosPorSexo', $seconds, function () use($candidatosVacinados) {
                                                
        //                                         return $this->vacinadosPorSexo($candidatosVacinados);
        //                                     });
 
        \Log::info("Fim");

        return view('home_estatistica')->with(['publicos'                => $publicos,
                                                'quantPessoasCadastradas' => $total['quantPessoasCadastradas'],
                                                'quantPessoasPriDose'     => $total['quantPessoasPriDose'],
                                                'quantPessoasSegDose'     => $total['quantPessoasSegDose'],
                                                'quantPessoasDoseUnica'   => $total['quantPessoasDoseUnica'],
                                                'aprovacao_enum'          => Candidato::APROVACAO_ENUM,
                                                // 'porcentagemVacinada'     => $total['porcentagemVacinada'],
                                                // 'quantVacinadosPorBairro' => $total['quantVacinadosPorBairro'],
                                                // 'quantVacinadosPorIdade'  => $total['quantVacinadosPorIdade'],
                                                // 'vacinadosPorSexo'        => $total['vacinadosPorSexo'],
                                                'config'                  => $config,
                                                'ultimaAtt'               => $ultimaAtualizacao]);
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
