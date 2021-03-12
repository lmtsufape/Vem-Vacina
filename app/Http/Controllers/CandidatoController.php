<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;

class CandidatoController extends Controller
{
    public function solicitar() {
        return view("form_solicitacao")->with(["sexos" => Candidato::SEXO_ENUM]);
    }

    public function enviar_solicitacao(Request $request) {

        $request->validate([
            "nome_completo" => "required",
            "data_de_nascimento" => "required|date",
            "numero_cartao_sus" => "required",
            "sexo" => "required",
            "nome_da_mae" => "required",
            "foto_frente_rg" => "required|mimes:jpeg,jpg,jpe,png,bmp",
            "foto_tras_rg" => "required|mimes:jpeg,jpg,jpe,png,bmp",
            "telefone" => "required",
            "cep" => "required",
            "cidade" => "required",
            "bairro" => "required",
            "logradouro" => "required",
            "numero_residencia" => "required",
        ]);

        $dados = $request->all();
        $candidato = new Candidato;
        $candidato->fill($dados);

        $candidato->paciente_acamado = isset($dados["paciente_acamado"]);

        if(isset($dados["paciente_agente_de_saude"])) {
            $candidato->paciente_agente_de_saude = true;
            $candidato->unidade_caso_agente_de_saude = $dados["unidade_caso_agente_de_saude"];
        } else {
            $candidato->paciente_agente_de_saude = false;
            $candidato->unidade_caso_agente_de_saude = "Não informado";
        }

        $candidato->foto_frente_rg = $request->file('foto_frente_rg')->store("public");
        $candidato->foto_tras_rg = $request->file('foto_frente_rg')->store("public");

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
}
