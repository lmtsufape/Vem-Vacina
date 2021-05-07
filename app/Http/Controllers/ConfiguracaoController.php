<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Candidato;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\CandidatoAprovado;
use Illuminate\Support\Facades\Notification;

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
            'numero_vacinas'              => 'nullable',
        ]);

        $config = Configuracao::first();
        $config->botao_solicitar_agendamento = ($request->botao_solicitar_agendamento != null);
        $config->botao_fila_de_espera        = ($request->botao_lista_de_espera != null);

        if ($request->link_do_botao_solicitar_agendamento != null) {
            $config->link_do_form_fila_de_espera = $request->link_do_botao_solicitar_agendamento;
        } else {
            $config->link_do_form_fila_de_espera = "Vazio";
        }

        if ($request->numero_vacinas != null) {
            $config->vacinas_recebidas = $request->numero_vacinas;
        } else {
            $config->vacinas_recebidas = 0;
        }


        $config->update();

        return redirect()->back()->with(['mensagem' => 'Configurações salvas']);
    }

    public function aprovarAgendamentos()
    {
        $candidatos = Candidato::withTrashed()->where('aprovacao', Candidato::APROVACAO_ENUM[0])->get();
        // dd($candidatos);
        foreach ($candidatos as $key => $candidato) {
            $candidato->aprovacao = Candidato::APROVACAO_ENUM[1];
            $candidato->update();
            if($candidato->email != null){
                $lote = DB::table("lote_posto_vacinacao")->where('id', $candidato->lote_id)->get();
                $lote = Lote::find($lote[0]->lote_id);
                Notification::send($candidato, new CandidatoAprovado($candidato, $lote ));
            }
            sleep(10);
        }
        return redirect()->back()->with(['mensagem' => 'Aprovados']);
    }
}
