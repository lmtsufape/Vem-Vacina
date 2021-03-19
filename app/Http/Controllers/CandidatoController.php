<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use App\Models\Lote;
use App\Models\PostoVacinacao;
use App\Models\Etapa;
use Illuminate\Support\Facades\DB;
use App\Notifications\CandidatoAprovado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;


class CandidatoController extends Controller
{
    public function show(Request $request) {
        $candidatos = null;

        if($request->filtro == null || $request->filtro == 1) {
            $candidatos = Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[0])->get();
        } else if ($request->filtro == 2) {
            $candidatos = Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[1])->get();
        } else if ($request->filtro == 3) {
            $candidatos = Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[2])->get();
        } else if ($request->filtro == 4) {
            $candidatos = Candidato::where('aprovacao', Candidato::APROVACAO_ENUM[3])->get();
        }

        return view('dashboard')->with(['candidatos' => $candidatos, 'candidato_enum' => Candidato::APROVACAO_ENUM]);
    }

    public function solicitar() {

        // TODO: pegar só os postos com vacinas disponiveis
        $postos_com_vacina = PostoVacinacao::all();

        return view("form_solicitacao")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
        ]);
    }
    public function ver($id) {
        return view("ver_agendamento", ["agendamento" => Candidato::find($id)]);
    }

    public function enviar_solicitacao(Request $request) {

        $request->validate([
            "nome_completo"         => "required",
            "data_de_nascimento"    => "required|date",
            "cpf"                   => "required",
            "número_cartão_sus"     => "required",
            "sexo"                  => "required",
            "nome_da_mãe"           => "required",
            "foto_frente_rg"        => "required|mimes:jpeg,jpg,jpe,png,bmp",
            "foto_tras_rg"          => "required|mimes:jpeg,jpg,jpe,png,bmp",
            "telefone"              => "required",
            "whatsapp"              => "nullable",
            "email"                 => "nullable",
            "cep"                   => "nullable",
            "cidade"                => "required",
            "bairro"                => "required",
            "rua"                   => "required",
            "número_residencial"    => "required",
            "complemento_endereco"  => "nullable",
            "posto_vacinacao"       => "required",
            "dia_vacinacao"         => "required",
            "horario_vacinacao"     => "required",
            "dose"                  => "required",
        ]);

        $dados = $request->all();

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
        $candidato->cep                     = $request->cep;
        $candidato->cidade                  = $request->cidade;
        $candidato->bairro                  = $request->bairro;
        $candidato->logradouro              = $request->rua;
        $candidato->numero_residencia       = $request->input("número_residencial");
        $candidato->complemento_endereco    = $request->complemento_endereco;
        $candidato->aprovacao               = Candidato::APROVACAO_ENUM[0];
        $candidato->dose                    = $request->dose;

        // Relacionar o candidato com uma etapa (se existir)
        $idade              = $this->idade($request->data_de_nascimento);
        $candidato->idade   = $idade;
        $etapa = Etapa::where([['inicio_intervalo', '<=', $idade], ['fim_intervalo', '>=', $idade], ['atual', true]])->first();
        if ($etapa != null) {
            $candidato->etapa_id = $etapa->id;
        } else {
            return redirect()->back()->withErrors([
                "faixa_etaria" => "Idade fora da faixa etária atual de vacinação"
            ])->withInput();
        }

        //TODO: mover pro service provider
        if(!$this->validar_cpf($request->cpf)) {
            return redirect()->back()->withErrors([
                "cpf" => "Número de CPF inválido"
            ])->withInput();

        }

        if(!$this->validar_telefone($request->telefone)) {
            return redirect()->back()->withErrors([
                "telefone" => "Número de telefone inválido"
            ])->withInput();
        }
        
        

        $dia_vacinacao = $request->dia_vacinacao;
        $horario_vacinacao = $request->horario_vacinacao;
        $id_posto = $request->posto_vacinacao;
        $datetime_chegada = Carbon::createFromFormat("d/m/Y H:i" , $dia_vacinacao . " " . $horario_vacinacao);
        $datetime_saida = $datetime_chegada->copy()->addMinutes(10);

        $candidatos_no_mesmo_horario_no_mesmo_lugar = Candidato::where("chegada", "=", $datetime_chegada)->where("posto_vacinacao_ìd", $id_posto)->get();

        if($candidatos_no_mesmo_horario_no_mesmo_lugar->count() > 0) {
            return redirect()->back()->withErrors([
                "posto_vacinacao" => "Alguém conseguiu preencher o formulário mais rápido que você, escolha outro horario por favor."
            ])->withInput();
        }

        // Pega a lista de todos os lotes que foram pra tal posto
        $lotes_disponiveis = DB::table("lote_posto_vacinacao")->where("posto_vacinacao_id", $id_posto)->get();

        $id_lote = 0;

        // Pra cada lote que esteje no posto
        foreach($lotes_disponiveis as $lote) {

            // Se a quantidade de candidatos à tomar a vicina daquele lote, naquele posto, que não foram reprovados
            // for menor que a quantidade de vacinas daquele lote que foram pra aquele posto, então o candidato vai tomar
            // daquele lote
            if(Candidato::where("lote_id", $lote->id)
               ->where("posto_vacinacao_ìd", $id_posto)
               ->where("aprovacao", "!=", Candidato::APROVACAO_ENUM[2])
               ->count() < $lote->qtdVacina) {
                $id_lote = $lote->id;
                break;
            }
        }

        if($id_lote == 0) { // Se é 0 é porque não tem vacinas...
            return redirect()->back()->withErrors([
                "posto_vacinacao" => "Não existem vacinas dispoiveis nesse posto..."
            ])->withInput();
        }


        $candidato->chegada                 = $datetime_chegada;
        $candidato->saida                   = $datetime_saida;
        $candidato->lote_id                 = $id_lote;
        $candidato->posto_vacinacao_ìd      = $id_posto;

        $candidato->paciente_acamado = isset($dados["paciente_acamado"]);

        if(isset($dados["paciente_agente_de_saude"])) {
            $candidato->paciente_agente_de_saude = true;
            $candidato->unidade_caso_agente_de_saude = $dados["unidade_caso_agente_de_saude"];
        } else {
            $candidato->paciente_agente_de_saude = false;
            $candidato->unidade_caso_agente_de_saude = "Não informado";
        }

        $candidato->foto_frente_rg = $request->file('foto_frente_rg')->store("public");
        $candidato->foto_tras_rg = $request->file('foto_tras_rg')->store("public");
        $candidato->save();

        return redirect()->back()->with('status', 'Cadastrado com sucesso');

    }

    public function uploadFile($request, $input, $nome){
    	if($request->hasFile($input)){
    		$path = $request->photo->storeAs('images', $nome, 'public');

    		return $path;
    	}
    	return null;
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'confirmacao' => 'required'
        ]);

        $candidato = Candidato::find($id);
        $candidato->aprovacao = $request->confirmacao;

        $candidato->update();
        if($candidato->email != null){
            Notification::send($candidato, new CandidatoAprovado($candidato));
        }
        return redirect()->back()->with(['mensagem' => 'Resposta salva com sucesso!']);
    }

    public function idade($data_nascimento) {
        $hoje = Carbon::today();
        return $hoje->diffInYears($data_nascimento);
    }

    public function vacinado($id) {
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

    public function dowloadFrenteRg($id) {
        $candidato = Candidato::find($id);

        if (Storage::disk()->exists($candidato->foto_frente_rg)) {
            return Storage::download($candidato->foto_frente_rg, $candidato->nome_completo . " - frente rg." . explode('.', $candidato->foto_frente_rg)[1]);
        }

        return abort(404);
    }
    
    public function dowloadVersoRg($id) {
        $candidato = Candidato::find($id);

        if (Storage::disk()->exists($candidato->foto_tras_rg)) {
            return Storage::download($candidato->foto_tras_rg, $candidato->nome_completo . " - verso rg." . explode('.', $candidato->foto_tras_rg)[1]);
        }

        return abort(404);
    }

    public function consultar(Request $request) {
        $validated = $request->validate([
            'consulta'  => "required",
            'cpf'       => 'required',
            'dose'      => 'required',
        ]);

        if(!$this->validar_cpf($request->cpf)) {
            return redirect()->back()->withErrors([
               "cpf" => "Número de CPF inválido"
           ])->withInput($validated);
        }

        $candidato = Candidato::where([['cpf', $request->cpf], ['dose', $request->dose]])->first();

        if ($candidato == null) {
            return redirect()->back()->withErrors([
                "cpf" => "Dados não encontrados"
            ])->withInput($validated);
        }

        return view("ver_agendamento", ["agendamento" => $candidato]);
    }
}
