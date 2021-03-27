<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracao;

class ConfiguracaoController extends Controller
{
    public function index() {
        $config = Configuracao::first();
        return view('config.index')->with(['config' => $config]);
    }

    public function update(Request $request) {

        $validate = $request->validate([
            'botao_solicitar_agendamento' => 'nullable',
            'botao_lista_de_espera'       => 'nullable',
            'link_do_botao_solicitar_agendamento' => 'required_if:botao_lista_de_espera,on',
        ]);

        $config = Configuracao::first();
        $config->botao_solicitar_agendamento = ($request->botao_solicitar_agendamento != null);
        $config->botao_fila_de_espera        = ($request->botao_lista_de_espera != null);

        if ($request->link_do_botao_solicitar_agendamento != null) {
            $config->link_do_form_fila_de_espera = $request->link_do_botao_solicitar_agendamento;
        } else {
            $config->link_do_form_fila_de_espera = "Vazio";
        }
        

        $config->update();

        return redirect()->back()->with(['mensagem' => 'Configurações salvar']);
    }
}
