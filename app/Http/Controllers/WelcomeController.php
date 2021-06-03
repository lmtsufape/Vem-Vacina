<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\PostoVacinacao;
use App\Models\Configuracao;
use App\Models\EstatisticaKeyCache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

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

        $ultimaAtualizacao = 0;
        $porcentagemVacinada = 0;
        $quantVacinadosPorBairro = [];
        $quantVacinadosPorIdade = [];
        $vacinadosPorSexo = [];
        $tempo = Carbon::now()->subDays(EstatisticaKeyCache::TEMPO_DE_CACHE);
        $checagem = EstatisticaKeyCache::where([['dado', 'ultimaAtualizacao'],['created_at', '>=', $tempo]])->first();
        if ($checagem == null) {
            $agora = now();
            $ultimaAtualizacao = $agora;
            $tempoDeCache = now()->addDays(EstatisticaKeyCache::TEMPO_DE_CACHE);

            $keyCacheUltimaAtt = Hash::make(Str::random(8));
            $keyCachePorcentagemVacinados = Hash::make(Str::random(8));
            $keyCacheQuantVacinadosPorBairro = Hash::make(Str::random(8));
            $keyCacheQauntVacinadosPorIdade = Hash::make(Str::random(8));
            $keyCacheVacinadosPorSexo = Hash::make(Str::random(8));

            $this->salvarCache($keyCacheUltimaAtt, $agora, $tempoDeCache, 'ultimaAtualizacao');

            $porcentagemVacinada = $this->porcentagemVacinada($quantPessoasPriDose);
            $this->salvarCache($keyCachePorcentagemVacinados, $porcentagemVacinada, $tempoDeCache, 'porcentagemVacinada');

            $quantVacinadosPorBairro = $this->quantVacinadosPorBairro($candidatosVacinados);
            $this->salvarCache($keyCacheQuantVacinadosPorBairro, $quantVacinadosPorBairro, $tempoDeCache, 'quantVacinadosPorBairro');

            $quantVacinadosPorIdade = $this->quantVacinadosPorIdade($candidatosVacinados);
            $this->salvarCache($keyCacheQauntVacinadosPorIdade, $quantVacinadosPorIdade, $tempoDeCache, 'quantVacinadosPorIdade');

            $vacinadosPorSexo = $this->vacinadosPorSexo($candidatosVacinados);
            $this->salvarCache($keyCacheVacinadosPorSexo, $vacinadosPorSexo, $tempoDeCache, 'vacinadosPorSexo');
        } else {
            $ultimaAtualizacao = Cache::get($checagem->key, 0);

            $porcentagemVacinada = $this->carregarCache('porcentagemVacinada', $tempo, 0);

            $quantVacinadosPorBairro = $this->carregarCache('quantVacinadosPorBairro', $tempo, []);

            $quantVacinadosPorIdade = $this->carregarCache('quantVacinadosPorIdade', $tempo, []);

            $vacinadosPorSexo = $this->carregarCache('vacinadosPorSexo', $tempo, []);
        }

        return view('welcome')->with(['publicos'                => $publicos,
                                      'quantPessoasCadastradas' => $quantPessoasCadastradas,
                                      'quantPessoasPriDose'     => $quantPessoasPriDose,
                                      'quantPessoasSegDose'     => $quantPessoasSegDose,
                                      'aprovacao_enum'          => Candidato::APROVACAO_ENUM,
                                      'porcentagemVacinada'     => $porcentagemVacinada,
                                      'quantVacinadosPorBairro' => $quantVacinadosPorBairro,
                                      'quantVacinadosPorIdade'  => $quantVacinadosPorIdade,
                                      'vacinadosPorSexo'        => $vacinadosPorSexo,
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

    public function salvarCache($key, $dado, $tempoDeCache, $nomeDoDado) {
        $estatisticaCache = new EstatisticaKeyCache();
        $estatisticaCache->dado = $nomeDoDado;
        $estatisticaCache->key  = $key;
        $estatisticaCache->save();

        Cache::put($key, $dado, $tempoDeCache->addMinutes(10));
    }

    public function carregarCache($nomeDoDado, $tempo, $padrao) {
        $checagem = EstatisticaKeyCache::where([['dado', $nomeDoDado],['created_at', '>=', $tempo]])->first();

        if ($checagem != null) {
            return Cache::get($checagem->key);
        }

        return $padrao;
    }
}
