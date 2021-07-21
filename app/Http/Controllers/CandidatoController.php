<?php

namespace App\Http\Controllers;

use DateTime;
use Throwable;
use DateInterval;
use Carbon\Carbon;
use App\Models\Lote;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use Illuminate\Validation\Rule;
use App\Notifications\Reagendado;
use App\Models\LotePostoVacinacao;
use Illuminate\Support\Facades\DB;
use App\Notifications\CandidatoFila;
use Illuminate\Support\Facades\Gate;
use App\Notifications\CandidatoAprovado;
use Illuminate\Support\Facades\Response;
use App\Notifications\CandidatoAtualizado;
use App\Notifications\CandidatoReprovado;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class CandidatoController extends Controller
{
    public function show(Request $request) {
        $candidatos = null;
        // dd($request->all());


        if ($request->tipo == "Não Analisado") {
            $query = Candidato::query()->where('aprovacao', Candidato::APROVACAO_ENUM[0]);
        }else if ($request->tipo == "Aprovado") {
            $query = Candidato::query()->where('aprovacao', Candidato::APROVACAO_ENUM[1]);
        }else if ($request->tipo == "Reprovado") {
            $query = Candidato::query()->onlyTrashed()->where('aprovacao', Candidato::APROVACAO_ENUM[2]);
        }else if ($request->tipo == "Vacinado") {
            $query = Candidato::query()->where('aprovacao', Candidato::APROVACAO_ENUM[3]);
        }else{
            $query = Candidato::query()->whereIn('aprovacao', [Candidato::APROVACAO_ENUM[1]]);
        }

        if ($request->nome_check && $request->nome != null) {
            $query->where('nome_completo', 'ilike', '%' . $request->nome . '%');
        }

        if ($request->ponto_check && $request->ponto != null) {
            $query->where('posto_vacinacao_id', $request->ponto);
        }

        if ($request->cpf_check && $request->cpf != null) {
            $query->where('cpf', 'ilike', '%'.$request->cpf.'%');
        }

        if ($request->data_check && $request->data != null) {
            $amanha = (new Carbon($request->data))->addDays(1);
            $hoje = (new Carbon($request->data));
            $query->where([['chegada','>=',$hoje], ['chegada','<=', $amanha]]);
        }
        if ($request->mes_check && $request->mes != null) {
            $mes0 = (new Carbon($request->mes))->format('m');
            $query->whereMonth('chegada',$mes0);
            // if(count($request->mes) == 2 && $request->mes[1] == null){
                //     $mes0 = (new Carbon($request->mes[0]))->format('m');
                //     $query->whereMonth('chegada', (new Carbon($request->mes[0]))->format('m'));
            // }elseif(count($request->mes) == 2 && $request->mes[1] != null){
            //     $mes0 = (new Carbon($request->mes[0]))->format('m');
            //     $mes1 = (new Carbon($request->mes[1]))->format('m');
            //     // $query->whereRaw('extract(month from chegada) = ?', [$mes0])
            //     //       ->orwhereRaw('extract(month from chegada) = ?', [$mes1]);
            //     // $query->whereMonth('chegada', [(new Carbon($request->mes[0]))->format('m'), (new Carbon($request->mes[1]))->format('m')]);
            //     $query->whereMonth('chegada','=',$mes0)
            //           ->orwhereMonth('chegada','=',$mes1);

            // }
        }
        if ($request->data_vacinado_check && $request->data_vacinado != null) {
            $amanha = (new Carbon($request->data_vacinado))->addDays(1);
            $hoje = (new Carbon($request->data_vacinado));
            $query->where([['updated_at','>=',$hoje], ['updated_at','<=', $amanha]]);
        }

        if ($request->dose_check && $request->dose != null) {
            $query->where('dose',$request->dose);
        }

        if ($request->aprovado) {
            $query->where('aprovacao', Candidato::APROVACAO_ENUM[1]);
        }

        if ($request->duplicado) {
            $query->where('cpf', Candidato::APROVACAO_ENUM[0]);
        }



        if ($request->publico_check) {
            if ($request->publico != null) {
                $query->where('etapa_id', $request->publico);
            }
        }

        if ($request->sus_check) {
            if ($request->sus) {
                $query->where('numero_cartao_sus', 'ilike', '%'.$request->sus.'%');
            }
        }

        if ($request->ordem_check && $request->ordem != null) {
            if($request->campo != null){
                $query->orderBy($request->campo, $request->ordem);
            }else{
                $query->orderBy('nome_completo', $request->ordem);
            }
        }

        if ($request->campo_check && $request->campo != null) {
            $query->orderBy($request->campo);
        }


        if ($request->outro) {
            $agendamentos = $query->get();
        } else {
            $agendamentos = $query->orderBy('created_at')->with(['etapa','outrasInfo', 'lote', 'resultado', 'posto'])->paginate($request->qtd)->withQueryString();
        }

        if ($request->outro) {
            $agendamentosComOutrasInfo = collect();

            foreach ($agendamentos as $agendamento) {
                $outros = $agendamento->outrasInfo;
                if($outros != null && count($outros) > 0) {
                    $agendamentosComOutrasInfo->push($agendamento);
                }
            }

            if ($agendamentosComOutrasInfo->count() > 0) {
                $agendamentos = $agendamentosComOutrasInfo;
            } else {
                $agendamentos = collect();
            }
        }

        session(['candidato_url' => $request->fullUrl()]);

        return view('dashboard2')->with(['candidatos' => $agendamentos,
                                        'candidato_enum' => Candidato::APROVACAO_ENUM,
                                        'tipos' => Etapa::TIPO_ENUM,
                                        'postos' => PostoVacinacao::all(),
                                        'doses' => Candidato::DOSE_ENUM,
                                        'publicos' => Etapa::orderBy('texto_home')->get(),
                                        'request' => $request]);
    }


    public function solicitar() {

        // TODO: pegar só os postos com vacinas disponiveis

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais   =  Etapa::where('atual', true)->orderBy('texto')->get();
        $config = Configuracao::first();

        if ($config->botao_solicitar_agendamento && auth()->user() == null) {
            abort(403);
        }

        $bairrosOrdenados = Candidato::bairros;
        // sort($bairrosOrdenados);

        return view("form_solicitacao")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos"    => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config"    => $config,
        ]);

    }
    public function ver($id) {
        return view("ver_agendamento", ["agendamento" => Candidato::find($id)]);
    }

    public function enviar_solicitacao(Request $request) {

        if(env('ATIVAR_FILA', false) == true){
            $request->merge(['fila' => "true"]);
        }
        // dd($request->all());
        $request->validate([
            "voltou"                => "nullable",
            "público"               => "required",
            "nome_completo"         => "required|string|min:8|max:65|regex:/^[\pL\s]+$/u",
            "data_de_nascimento"    => "required|date|before:today",
            "cpf"                   => "required",
            "número_cartão_sus"     => "required",
            "sexo"                  => "required",
            "nome_da_mãe"           => "required|string|min:8|max:65|regex:/^[\pL\s]+$/u",
            "telefone"              => "required",
            "whatsapp"              => "nullable",
            "email"                 => "nullable|email",
            "cep"                   => "nullable",
            // "cidade"                => "required", // como valor é fixado no front, pode ser desabilitado e hardcoded aqui no controller
            "bairro"                => "required",
            "rua"                   => "required|regex:/[a-zA-Z0-9\s]+/|min:5", // Na cohab 2, as pessoas não sabem os nomes das ruas, só os numeros, então tem gente que vai por "Rua 2"
            "número_residencial"    => "required|regex:/[a-zA-Z0-9\s]+/",
            "complemento_endereco"  => "nullable",
            "posto_vacinacao"       => Rule::requiredIf(!$request->has('fila')),
            "dia_vacinacao"         => Rule::requiredIf(!$request->has('fila')),
            "horario_vacinacao"     => Rule::requiredIf(!$request->has('fila')),
            "opcao_etapa_".$request->input('público') => 'nullable',
        ]);

        // dd($request->all());
        DB::beginTransaction();

        try {
            if (Candidato::where('cpf',$request->cpf)->where('aprovacao','!=', Candidato::APROVACAO_ENUM[2])
            ->count() > 0) {
                return redirect()->back()->withErrors([
                    "cpf" => "Existe um agendamento pendente para esse CPF."
                ])->withInput();
            }


            $candidato = new Candidato;
            $candidato->nome_completo           = $request->nome_completo;
            $candidato->data_de_nascimento      = $request->data_de_nascimento;
            $candidato->cpf                     = $request->cpf;
            $candidato->numero_cartao_sus       = $request->input("número_cartão_sus");
            $candidato->sexo                    = $request->sexo;
            $candidato->nome_da_mae             = $request->input("nome_da_mãe");
            $candidato->telefone                = $request->telefone;
            $candidato->whatsapp                = $request->whatsapp;
            $candidato->email                   = $request->email;
            $candidato->cep                     = preg_replace('/[^0-9]/', '', $request->cep);
            // $candidato->cidade                  = $request->cidade;
            $candidato->cidade                  = "Garanhuns";
            $candidato->bairro                  = $request->bairro;
            $candidato->logradouro              = $request->rua;
            $candidato->numero_residencia       = $request->input("número_residencial");
            $candidato->complemento_endereco    = $request->complemento_endereco;
            $candidato->aprovacao               = Candidato::APROVACAO_ENUM[1];
            $candidato->dose                    = Candidato::DOSE_ENUM[0];

            // Se não foi passado CEP, o preg_replace retorna string vazia, mas no bd é uint nulavel, então anula
            if ($candidato->cep == "") {
                $candidato->cep = NULL;
            }

            // Relacionar o candidato com o público escolhido e realiza
            // a validação de acordo com o público escolhido
            $idade              = $this->idade($request->data_de_nascimento);
            $candidato->idade   = $idade;

            $etapa = Etapa::find($request->input('público'));

            if ($etapa->tipo == Etapa::TIPO_ENUM[0]) {
                if (!($etapa->inicio_intervalo <= $idade && $etapa->fim_intervalo >= $idade)) {
                    return redirect()->back()->withErrors([
                        "data_de_nascimento" => "Idade fora da faixa etária de vacinação."
                    ])->withInput();
                }
            } else if ($etapa->tipo == Etapa::TIPO_ENUM[2]) {
                if (!($etapa->inicio_intervalo <= $idade && $etapa->fim_intervalo >= $idade)) {
                    return redirect()->back()->withErrors([
                        "data_de_nascimento" => "Idade fora da faixa etária de vacinação."
                    ])->withInput();
                }

                if ($request->input("publico_opcao_" . $request->input('público')) == null) {
                    return redirect()->back()->withErrors([
                        "publico_opcao_" . $request->input('público') => "Esse campo é obrigatório para público marcado."
                    ])->withInput();
                }
                $candidato->etapa_resultado = $request->input("publico_opcao_" . $request->input('público'));
            }

            if ($etapa->outras_opcoes_obrigatorio != null && $etapa->outras_opcoes_obrigatorio) {
                if (!($request->input("opcao_etapa_".$etapa->id) != null && count($request->input("opcao_etapa_".$etapa->id)) > 0)) {
                    return redirect()->back()->withErrors([
                        "outras_infor_obg_" . $request->input('público') => "Você deve marcar pelo menos uma informação para esse público."
                    ])->withInput();
                }
            }

            $candidato->etapa_id = $etapa->id;
            //TODO: mover pro service provider
            if (!$this->validar_cpf($request->cpf)) {
                return redirect()->back()->withErrors([
                    "cpf" => "Número de CPF inválido"
                ])->withInput();
            }

            if (!$this->validar_telefone($request->telefone)) {
                return redirect()->back()->withErrors([
                    "telefone" => "Número de telefone inválido"
                ])->withInput();
            }


            if($request->has('fila')){
                $candidato->aprovacao = Candidato::APROVACAO_ENUM[0];
                $candidato->save();
                Notification::send($candidato, new CandidatoFila($candidato));
                DB::commit();
                if ($etapa->outrasInfo != null && count($etapa->outrasInfo) > 0) {
                    if ($request->input("opcao_etapa_".$etapa->id) != null && count($request->input("opcao_etapa_".$etapa->id)) > 0) {
                        foreach ($request->input("opcao_etapa_".$etapa->id) as $outra_info_id) {
                            $candidato->outrasInfo()->attach($outra_info_id);
                        }
                    }
                }
                $agendamentos = [];
                array_push($agendamentos, $candidato);
                return view('comprovante')->with(['status' => 'Solicitação realizada com sucesso!',
                                            'agendamentos' => $agendamentos,
                                            'aprovacao_enum' => Candidato::APROVACAO_ENUM,]);
            }


            $dia_vacinacao = $request->dia_vacinacao;
            $horario_vacinacao = $request->horario_vacinacao;
            $id_posto = $request->posto_vacinacao;
            $datetime_chegada = Carbon::createFromFormat("d/m/Y H:i", $dia_vacinacao . " " . $horario_vacinacao);
            $datetime = $datetime_chegada;
            $datetime_saida = $datetime_chegada->copy()->addMinutes(10);

            $candidatos_no_mesmo_horario_no_mesmo_lugar = Candidato::where("chegada", "=", $datetime)->where("posto_vacinacao_id", $id_posto)->get();

            if ($candidatos_no_mesmo_horario_no_mesmo_lugar->count() > 0) {
                return redirect()->back()->withErrors([
                    "posto_vacinacao" => "Alguém conseguiu preencher o formulário mais rápido que você, escolha outro horario por favor."
                ])->withInput();
            }

            $etapa = Etapa::where('id',$request->input('público'))->first();

            if(!$etapa->lotes->count()){
                $candidato->aprovacao = Candidato::APROVACAO_ENUM[0];
                $candidato->save();
                Notification::send($candidato, new CandidatoFila($candidato));
                DB::commit();
                $agendamentos = [];
                array_push($agendamentos, $candidato);
                return view('comprovante')->with(['status' => 'Solicitação realizada com sucesso!',
                                            'agendamentos' => $agendamentos,
                                            'aprovacao_enum' => Candidato::APROVACAO_ENUM,]);
            }
            //Retorna um array de IDs do lotes associados a etapa escolhida
            $array_lotes_disponiveis = $etapa->lotes->pluck('id');


            // Pega a lista de todos os lotes da etapa escolhida para o posto escolhido
            $lotes_disponiveis = DB::table("lote_posto_vacinacao")->where("posto_vacinacao_id", $id_posto)
                                    ->whereIn('lote_id', $array_lotes_disponiveis)->get();

            $id_lote = 0;

            // Pra cada lote que esteje no posto
            foreach ($lotes_disponiveis as $lote) {

                // Se a quantidade de candidatos à tomar a vicina daquele lote, naquele posto, que não foram reprovados
                // for menor que a quantidade de vacinas daquele lote que foram pra aquele posto, então o candidato vai tomar
                // daquele lote

                $lote_original = Lote::find($lote->lote_id);
                $qtdCandidato = Candidato::where("lote_id", $lote->id)->where("posto_vacinacao_id", $id_posto)->where("aprovacao",  Candidato::APROVACAO_ENUM[1])
                                            ->count();
                if(!$lote_original->dose_unica){
                    //Se o lote disponivel for de vacina com dose dupla vai parar aqui
                    //e verifica se tem duas vacinas disponiveis
                    if (($qtdCandidato + 1) < $lote->qtdVacina) {
                        $id_lote = $lote->id;
                        $chave_estrangeiro_lote = $lote->lote_id;
                        $qtd = $lote->qtdVacina - $qtdCandidato;

                        if ( !$lote_original->dose_unica && !($qtd >= 2) ) {
                            $candidato->aprovacao = Candidato::APROVACAO_ENUM[0];
                            $candidato->save();
                            Notification::send($candidato, new CandidatoFila($candidato));
                            DB::commit();
                            $agendamentos = [];
                            array_push($agendamentos, $candidato);
                            return view('comprovante')->with(['status' => 'Solicitação realizada com sucesso!',
                                            'agendamentos' => $agendamentos,
                                            'aprovacao_enum' => Candidato::APROVACAO_ENUM,]);
                            // return redirect()->back()->withErrors([
                            //     "posto_vacinacao" => "Não há mais doses disponíveis. Favor realize o seu cadastro na fila de espera pela página principal."
                            // ])->withInput();
                        }
                        break;
                    }

                }else{
                    //Se o lote disponivel for de vacina com dose unica vai parar aqui
                    //e verifica se tem pelo menos uma ou mais vacinas disponiveis
                    if ($qtdCandidato < $lote->qtdVacina) {
                        $id_lote = $lote->id;
                        $chave_estrangeiro_lote = $lote->lote_id;
                        $candidato->dose = "Dose única";
                        break;
                    }
                }

            }

            if ($id_lote == 0) { // Se é 0 é porque não tem vacinas...
                $candidato->aprovacao = Candidato::APROVACAO_ENUM[0];
                $candidato->save();
                Notification::send($candidato, new CandidatoFila($candidato));
                DB::commit();
                $agendamentos = [];
                array_push($agendamentos, $candidato);
                return view('comprovante')->with(['status' => 'Solicitação realizada com sucesso!',
                                            'agendamentos' => $agendamentos,
                                            'aprovacao_enum' => Candidato::APROVACAO_ENUM,]);
            }

            $candidato->chegada                 = $datetime_chegada;
            $candidato->saida                   = $datetime_saida;
            $candidato->lote_id                 = $id_lote;
            $candidato->posto_vacinacao_id      = $id_posto;

            $posto = PostoVacinacao::find($id_posto);

            $posto->dias->where('dia', $datetime_chegada->copy()->startOfDay())->first()->horarios->where('horario', $datetime_chegada)->first()->delete();
            $posto->refresh();
            // dd($posto->dias->where('dia', $datetime_chegada->copy()->startOfDay())->first()->horarios->where('horario', $datetime_chegada)->first());


            $candidato->save();
            $candidatoSegundaDose = null;

            $lote = Lote::find($chave_estrangeiro_lote);

            if (!$lote->dose_unica) {
                $datetime_chegada_segunda_dose = $candidato->chegada->add(new DateInterval('P'.$lote->inicio_periodo.'D'));
                if($datetime_chegada_segunda_dose->format('l') == "Sunday" || $datetime_chegada_segunda_dose->format('l') == "Saturday"){
                    $datetime_chegada_segunda_dose->add(new DateInterval('P3D'));
                }
                $candidatoSegundaDose = $candidato->replicate()->fill([
                    'chegada' =>  $datetime_chegada_segunda_dose,
                    'saida'   =>  $datetime_chegada_segunda_dose->copy()->addMinutes(10),
                    'dose'   =>  Candidato::DOSE_ENUM[1],
                ]);

                $candidatoSegundaDose->save();

                if ($etapa->outrasInfo != null && count($etapa->outrasInfo) > 0) {
                    if ($request->input("opcao_etapa_".$etapa->id) != null && count($request->input("opcao_etapa_".$etapa->id)) > 0) {
                        foreach ($request->input("opcao_etapa_".$etapa->id) as $outra_info_id) {
                            $candidatoSegundaDose->outrasInfo()->attach($outra_info_id);
                        }
                    }
                }
            }

            if($candidato->email != null){
                Notification::send($candidato, new CandidatoAprovado($candidato, $candidatoSegundaDose,$lote));
            }


            if ($etapa->outrasInfo != null && count($etapa->outrasInfo) > 0) {
                if ($request->input("opcao_etapa_".$etapa->id) != null && count($request->input("opcao_etapa_".$etapa->id)) > 0) {
                    foreach ($request->input("opcao_etapa_".$etapa->id) as $outra_info_id) {
                        $candidato->outrasInfo()->attach($outra_info_id);
                    }
                }
            }


            DB::commit();

        } catch (\Throwable $e) {
            DB::rollback();

            if(env('APP_DEBUG')){
                return redirect()->back()->withErrors([
                    "message" => $e->getMessage(),
                ])->withInput();
            }
            return redirect()->back()->withErrors([
                "message" => "Houve algum erro, entre em contato com a administração do site.",
            ])->withInput();
        }

        if(!Candidato::where('cpf', $candidato->cpf)->count()){
            return redirect()->back()->withErrors([
                "message" => "Houve algum erro, entre em contato com a administração do site.",
            ])->withInput();
        }

        $agendamentos = Candidato::where('cpf', $candidato->cpf)->orderBy('dose')->get();


        return view('comprovante')->with(['status' => 'Solicitação realizada com sucesso!',
                                          'agendamentos' => $agendamentos,
                                          'aprovacao_enum' => Candidato::APROVACAO_ENUM,]);
    }

    public function comprovante()
    {
        return view('comprovante')->with('status', 'Cadastrado com sucesso');
    }

    public function uploadFile($request, $input, $nome){
    	if($request->hasFile($input)){
    		$path = $request->photo->storeAs('images', $nome, 'public');

    		return $path;
    	}
    	return null;
    }

    public function update(Request $request, $id) {
        Gate::authorize('confirmar-vaga-candidato');
        $validated = $request->validate([
            'confirmacao' => 'required'
        ]);

        $candidato = Candidato::withTrashed()->find($id);
        // $lote = DB::table("lote_posto_vacinacao")->where('id', $candidato->lote_id)->get();
        // $lote = Lote::find($lote[0]->lote_id);
        // dd($lote);
        if($request->confirmacao == "Ausente"){
            $candidato = Candidato::find($id);
            if ($candidato != null) {
                Candidato::where('id',$id)->update(['aprovacao' => "Reprovado"]);
                Candidato::where('id',$id)->delete();
                // Candidato::where('cpf',$candidato->cpf)->update(['aprovacao' => "Reprovado"]);
                // Candidato::where('cpf',$candidato->cpf)->delete();
            }

        }elseif($request->confirmacao == "Aprovado"){
            $candidato = Candidato::find($id);
            if ($candidato != null) {
                $candidato->aprovacao = Candidato::APROVACAO_ENUM[1];
                $candidato->update();

                // if($candidato->email != null){
                //     $lote = DB::table("lote_posto_vacinacao")->where('id', $candidato->lote_id)->get();
                //     $lote = Lote::find($lote[0]->lote_id);
                //     // Notification::send($candidato, new CandidatoAprovado($candidato, null));
                // }
            }

        }elseif($request->confirmacao == "Reprovado"){
            if ($candidato != null) {
                Candidato::where('cpf',$candidato->cpf)->where('nome_completo',$candidato->nome_completo)
                        ->update(['aprovacao' => "Reprovado"]);

                if($candidato->email != null){
                    Notification::send($candidato, new CandidatoReprovado($candidato));
                }
                Candidato::where('cpf',$candidato->cpf)->where('nome_completo',$candidato->nome_completo)->delete();


            }

        }elseif($request->confirmacao == "restaurar"){

            $candidato = Candidato::withTrashed()
                                    ->where('id', $id)
                                    ->restore();
            if ($candidato != null) {
                $candidato = Candidato::withTrashed()->find($id);
                $candidato->aprovacao = Candidato::APROVACAO_ENUM[0];
                $candidato->update();
            }

        }

        return redirect()->back()->with(['mensagem' => 'Resposta salva com sucesso!']);
    }

    public function idade($data_nascimento) {
        $hoje = Carbon::today();
        return $hoje->diffInYears($data_nascimento);
    }

    public function vacinado($id) {
        Gate::authorize('vacinado-candidato');
        $candidato = Candidato::find($id);
        $candidato->aprovacao = Candidato::APROVACAO_ENUM[3];
        $candidato->update();

        $etapa = $candidato->etapa;
        if ($etapa != null) {
            if ($candidato->dose == Candidato::DOSE_ENUM[0]) {
                $etapa->total_pessoas_vacinadas_pri_dose += 1;
            } else if ($candidato->dose == Candidato::DOSE_ENUM[1]) {
                $etapa->total_pessoas_vacinadas_seg_dose += 1;
            }
            $etapa->update();
        }

        return redirect()->back()->with(['mensagem' => 'Confirmação salva.']);
    }
    public function vacinadoAjax(Request $request) {
        // return response()->json($request->id);
        // return response()->json('Vacinado com sucesso!');
        Gate::authorize('vacinado-candidato');
        $candidato = Candidato::find($request->id);
        $candidato->aprovacao = Candidato::APROVACAO_ENUM[3];
        $candidato->update();

        $etapa = $candidato->etapa;
        if ($etapa != null) {
            if ($candidato->dose == Candidato::DOSE_ENUM[0]) {
                $etapa->total_pessoas_vacinadas_pri_dose += 1;
            } else if ($candidato->dose == Candidato::DOSE_ENUM[1]) {
                $etapa->total_pessoas_vacinadas_seg_dose += 1;
            }
            $etapa->update();
        }

        return response()->json('Vacinado com sucesso!');
    }
    public function desmarcarVacinadoAjax(Request $request) {
        // return response()->json($request->id);
        // return response()->json('Vacinado com sucesso!');
        Gate::authorize('vacinado-candidato');
        $candidato = Candidato::find($request->id);
        $candidato->aprovacao = Candidato::APROVACAO_ENUM[1];
        $candidato->update();

        $etapa = $candidato->etapa;
        if ($etapa != null) {
            if ($candidato->dose == Candidato::DOSE_ENUM[0]) {
                $etapa->total_pessoas_vacinadas_pri_dose -= 1;
            } else if ($candidato->dose == Candidato::DOSE_ENUM[1]) {
                $etapa->total_pessoas_vacinadas_seg_dose -= 1;
            }
            $etapa->update();
        }

        return response()->json('Atualização feita!');
    }

    public function consultar(Request $request) {
        $validated = $request->validate([
            'consulta'              => "required",
            'cpf'                   => 'required',
            'data_de_nascimento'    => 'required'
        ]);

        if(!$this->validar_cpf($request->cpf)) {
            return redirect()->back()->withErrors([
               "cpf" => "Número de CPF inválido"
           ])->withInput($validated);
        }

        $agendamentos = Candidato::where([['cpf', $request->cpf], ['data_de_nascimento', $request->data_de_nascimento]])
                      ->orderBy("dose") // Mostra primeiro o agendamento mais recente
                      ->get();

        if ($agendamentos->count() == 0) {
            return redirect()->back()->withErrors([
                "cpf" => "Dados não encontrados"
            ])->withInput($validated);
        }

        return view("comprovante")->with(["status" => "Resultado da consulta", "agendamentos" => $agendamentos, 'aprovacao_enum' => Candidato::APROVACAO_ENUM,]);
    }

    public function CandidatoLote()
    {
        $candidatos = Candidato::all();
        return view('candidatoLote', compact('candidatos'));
    }

    public function ordenar($field ,$order)
    {

        $candidatos = Candidato::orderBy($field, $order)->get();

        return view('dashboard')->with(['candidatos' => $candidatos,
                                        'candidato_enum' => Candidato::APROVACAO_ENUM,
                                        'tipos' => Etapa::TIPO_ENUM,
                                        'doses' => Candidato::DOSE_ENUM]);

    }
    public function ordenarNovaLista($field ,$order)
    {

        $candidatos = Candidato::orderBy($field, $order)->get();

        return view('agendamentos.apendentes')->with(['candidatos' => $candidatos,
                                        'candidato_enum' => Candidato::APROVACAO_ENUM,
                                        'tipos' => Etapa::TIPO_ENUM]);

    }

    public function filtro($field ,$tipo)
    {

        if($tipo == "Chegada"){
            $candidatos = Candidato::where('chegada','like',date("Y-m-d")."%")->get();
        }else{

            $candidatos = Candidato::where($field, $tipo)->get();
        }


        return back()->with(['candidatos' => $candidatos,
                                        'candidato_enum' => Candidato::APROVACAO_ENUM,
                                        'tipos' => Etapa::TIPO_ENUM]);

    }

    public function filtroAjax(Request $request) {
        $query = Candidato::query();

        if ($request->nome_check && $request->nome != null) {
            $query->where('nome_completo', 'ilike', '%' . $request->nome . '%');
        }

        if ($request->cpf_check && $request->cpf != null) {
            $query->where('cpf', $request->cpf);
        }

        if ($request->data_check && $request->data != null) {
            $query->where('chegada','like',$request->data."%");
        }

        if ($request->dose_check && $request->dose != null) {
            $query->where('dose',$request->dose);
        }

        if ($request->aprovado) {
            $query->where('aprovacao', Candidato::APROVACAO_ENUM[1]);
        }

        if ($request->reprovado) {
            $query->withTrashed()->where('aprovacao', Candidato::APROVACAO_ENUM[2]);
        }

        $agendamentos = $query->orderBy('nome_completo')->get();

        if ($request->outro) {
            $agendamentosComOutrasInfo = collect();

            foreach ($agendamentos as $agendamento) {
                $outros = $agendamento->outrasInfo;
                if($outros != null && count($outros) > 0) {
                    $agendamentosComOutrasInfo;
                }
            }

            if ($agendamentosComOutrasInfo->count() > 0) {
                $agendamentos = $agendamentosComOutrasInfo;
            } else {
                $agendamentos = collect();
            }
        }

        return $agendamentos;
    }

    public function reagendar(Request $request, $id) {
        $candidato = Candidato::find($id);

        $validated = $request->validate([
            'edit_agendamento_id'       => 'required',
            'posto_vacinacao_' . $id    => 'required',
            'dia_vacinacao_' . $id      => 'required',
            'horario_vacinacao_' . $id  => 'required',
        ]);

        $dia_vacinacao          = $request->input('dia_vacinacao_'.$id);
        $horario_vacinacao      = $request->input('horario_vacinacao_'.$id);
        $id_posto               = $request->input('posto_vacinacao_'.$id);
        $datetime_chegada       = Carbon::createFromFormat("d/m/Y H:i", $dia_vacinacao . " " . $horario_vacinacao);
        $datetime_saida         = $datetime_chegada->copy()->addMinutes(10);

        $candidatos_no_mesmo_horario_no_mesmo_lugar = Candidato::where("chegada", "=", $datetime_chegada)->where("posto_vacinacao_id", $id_posto)->get();
        // DB::beginTransaction();

        try {
        if ($candidatos_no_mesmo_horario_no_mesmo_lugar->count() > 0) {
            return redirect()->back()->with([
                'message' . $id => "Alguém conseguiu preencher o formulário mais rápido, escolha outro horario por favor."
            ])->withInput();
        }
        $etapa = $candidato->etapa;
        if(!$etapa->lotes->count()){
            return redirect()->back()->with([
                'message' . $id => "Não há vacinas."
            ])->withInput();
        }
        //Retorna um array de IDs do lotes associados a etapa escolhida
        $array_lotes_disponiveis = $etapa->lotes->pluck('id');


        // Pega a lista de todos os lotes da etapa escolhida para o posto escolhido
        $lotes_disponiveis = DB::table("lote_posto_vacinacao")->where("posto_vacinacao_id", $id_posto)
                                ->whereIn('lote_id', $array_lotes_disponiveis)->get();

        $id_lote = 0;

        // Pra cada lote que esteje no posto
        foreach ($lotes_disponiveis as $lote) {

            // Se a quantidade de candidatos à tomar a vicina daquele lote, naquele posto, que não foram reprovados
            // for menor que a quantidade de vacinas daquele lote que foram pra aquele posto, então o candidato vai tomar
            // daquele lote

            $lote_original = Lote::find($lote->lote_id);
            $qtdCandidato = Candidato::where("lote_id", $lote->id)->where("posto_vacinacao_id", $id_posto)->where("aprovacao",  Candidato::APROVACAO_ENUM[1])
                                        ->count();
            if(!$lote_original->dose_unica){
                //Se o lote disponivel for de vacina com dose dupla vai parar aqui
                //e verifica se tem duas vacinas disponiveis
                if (($qtdCandidato + 1) < $lote->qtdVacina) {
                    $id_lote = $lote->id;
                    $chave_estrangeiro_lote = $lote->lote_id;
                    $qtd = $lote->qtdVacina - $qtdCandidato;

                    if ( !$lote_original->dose_unica && !($qtd >= 2) ) {
                        return redirect()->back()->with([
                            'message' . $id => "Não há vacinas."
                        ])->withInput();
                        // return redirect()->back()->with([
                        //     "posto_vacinacao" => "Não há mais doses disponíveis. Favor realize o seu cadastro na fila de espera pela página principal."
                        // ])->withInput();
                    }
                    break;
                }

            }else{
                //Se o lote disponivel for de vacina com dose unica vai parar aqui
                //e verifica se tem pelo menos uma ou mais vacinas disponiveis
                if ($qtdCandidato < $lote->qtdVacina) {
                    $id_lote = $lote->id;
                    $chave_estrangeiro_lote = $lote->lote_id;
                    break;
                }
            }

        }

        if ($id_lote == 0) { // Se é 0 é porque não tem vacinas...

            return redirect()->back()->with([
                'message' . $id => "Não há vacinas."
            ])->withInput();
        }


        $candidato->posto_vacinacao_id      = $id_posto;
        $candidato->chegada                 = $datetime_chegada;
        $candidato->saida                   = $datetime_saida;
        $candidato->lote_id                 = $id_lote;
        $candidato->update();


        $candidatoSegundaDose = null;
        $lote = LotePostoVacinacao::find($candidato->lote_id)->lote;

        // Se o agendamento for de primeira dose a segunda dose deve ser reajustada
        // para a quantidade de dias do lote escolhido
        if ($candidato->dose == Candidato::DOSE_ENUM[0]) {

            if ($lote != null && !$lote->dose_unica) {
                $candidatoSegundaDose = Candidato::where([['cpf', $candidato->cpf], ['dose', Candidato::DOSE_ENUM[1]]])->first();

                $datetime_chegada_segunda_dose = $candidato->chegada->add(new DateInterval('P'.$lote->inicio_periodo.'D'));
                if($datetime_chegada_segunda_dose->format('l') == "Sunday"){
                    $datetime_chegada_segunda_dose->add(new DateInterval('P1D'));
                }

                if ($candidatoSegundaDose != null) {
                    $candidatoSegundaDose->chegada              =  $datetime_chegada_segunda_dose;
                    $candidatoSegundaDose->saida                =  $datetime_chegada_segunda_dose->copy()->addMinutes(10);
                    $candidatoSegundaDose->dose                 =  Candidato::DOSE_ENUM[1];
                    $candidatoSegundaDose->posto_vacinacao_id   =  $id_posto;
                    $candidatoSegundaDose->lote_id                 = $id_lote;
                    $candidatoSegundaDose->update();
                }

            }
        }
        // DB::commit();
        } catch (\Throwable $e) {
            // DB::rollback();
            if(env('APP_DEBUG')){
                return redirect()->back()->withErrors([
                    "message" => $e->getMessage(),
                ])->withInput();
            }
            return redirect()->back()->withErrors([
                "message" => "Houve algum erro, entre em contato com a administração do site.",
            ])->withInput();
        }
        if($candidato->email != null && $candidatoSegundaDose != null){
            Notification::send($candidato, new Reagendado($candidato, $candidatoSegundaDose));
        }


        return redirect()->back()->with(['mensagem' => 'Reagendado com sucesso.']);
    }

    public function desfazerVacinado($id) {
        Gate::authorize('vacinado-candidato');
        $candidato = Candidato::find($id);
        $candidato->aprovacao = Candidato::APROVACAO_ENUM[1];
        $candidato->update();

        $etapa = $candidato->etapa;
        if ($etapa != null) {
            if ($candidato->dose == Candidato::DOSE_ENUM[0]) {
                $etapa->total_pessoas_vacinadas_pri_dose -= 1;
            } else if ($candidato->dose == Candidato::DOSE_ENUM[1]) {
                $etapa->total_pessoas_vacinadas_seg_dose -= 1;
            }
            $etapa->update();
        }

        return redirect()->back()->with(["mensagem" => "Vacinação desfeita."]);
    }

    public function form_edit($id) {
        Gate::authorize('editar-candidato');
        $candidato = Candidato::find($id);
        $candidatos = Candidato::where('cpf', $candidato->cpf)->orderBy('dose')->get();

        return view('candidato.editar_data', compact('candidatos'));
    }

    public function editarData(Request $request, $id)
    {
        try {
            Gate::authorize('editar-candidato');
            DB::beginTransaction();

            $candidato1 = Candidato::find($id);

            if($candidato1->aprovacao != "Aprovado"){
                return back()->with(['message' => "Não permitido"]);
            }
            $candidato1->update([
                'chegada'         => $request->chegada,
                'saida'         => $candidato1->chegada->copy()->modify('+2 minutes'),
            ]);
            if($candidato1->dose == "1ª Dose" && Candidato::where('cpf',$candidato1->cpf)->where('id', '!=',$id)->first() != null){
                $lote = LotePostoVacinacao::findOrFail($candidato1->lote_id)->lote;
                $candidato2 = Candidato::where('cpf',$candidato1->cpf)->where('id', '!=',$id)->first();
                $datetime_chegada_segunda_dose = $candidato1->chegada->add(new DateInterval('P'.$lote->inicio_periodo.'D'));
                // dd($datetime_chegada_segunda_dose);
                $candidato2->update([
                    'chegada'         => $datetime_chegada_segunda_dose,
                    'saida'         => $datetime_chegada_segunda_dose->copy()->modify('+2 minutes'),
                ]);
            }

            if($candidato1->email != null){
                Notification::send($candidato1, new CandidatoAtualizado($candidato1));
            }
            DB::commit();
            if ($request->session()->has('candidato_url')) {
                session(['candidato_id' => $candidato1->id]);

                return redirect(session('candidato_url', 'dashboard'))->with(['message' => "Atualizado com sucesso"]);

            }


            return back()->with(['message' => "Atualizado com sucesso"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(['message' => $th->getMessage()]);
        }
    }

    public function editar(Request $request) {


        try {
            Gate::authorize('editar-candidato');


            $validator = Validator::make($request->all(), [
                "nome_completo"         => "required|string|min:8|max:65|regex:/^[\pL\s]+$/u",
                "data_de_nascimento"    => "required|date|before:today",
                "cpf"                   => "required|regex:/^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/u",
                "numero_cartao_sus"     => "required",
                "nome_da_mae"           => "required|string|min:8|max:65|regex:/^[\pL\s]+$/u",
                "observacao"     => "required",
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }

            if (Candidato::where('cpf',$request->cpf)->where('id', '!=',$request->id)->where('aprovacao','!=', Candidato::APROVACAO_ENUM[2])->count() > 1) {
                    return response()->json([["Já existe alguém com esse CPF"]], 400);
            }
            $candidato = Candidato::find($request->id);
            Candidato::where('cpf', $candidato->cpf)->update([
                'nome_completo'         => $request->nome_completo,
                'cpf'                   => $request->cpf,
                'data_de_nascimento'    => $request->data_de_nascimento,
                'numero_cartao_sus'     => $request->numero_cartao_sus,
                'nome_da_mae'           => $request->nome_da_mae,
                'observacao'           => $request->observacao,
            ]);


            return response()->json(['message' => "atualizado com sucesso"]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }

    }
}
