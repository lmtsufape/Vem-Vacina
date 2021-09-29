<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;

class ReforcoController extends Controller
{
    public function index()
    {
        return view('reforco.index');
    }

    public function verificar(Request $request)
    {
        $validate = $request->validate([
            'cpf' => 'required',
            'data_de_nascimento' => 'required|date',
        ]);
        
        $candidatos = Candidato::where('cpf', $validate['cpf'])
                                ->where('data_de_nascimento', $validate['data_de_nascimento'])
                                ->orderBy('dose')
                                ->take(2)->get();
        
        if (count($candidatos) > 0 ) {
            return redirect()->route('solicitacao.reforco',[ 'candidato' => $candidatos[0]->id]);
        }else{
            return view('reforco.data_dose', compact('validate'));
        }
    }

    public function solicitarDoseTres($candidato) {

        // TODO: pegar só os postos com vacinas disponiveis

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais   =  Etapa::where('atual', true)->orderBy('texto')->get();
        $config = Configuracao::first();

        if ($config->botao_solicitar_agendamento && auth()->user() == null) {
            abort(403);
        }

        $bairrosOrdenados = Candidato::bairros;
        // sort($bairrosOrdenados);

        return view("reforco.form_dose_tres")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos"    => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config"    => $config,
        ]);

    }

    public function solicitarReforco($candidato) {

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais   =  Etapa::where('atual', true)->orderBy('texto')->get();
        $config = Configuracao::first();

        if ($config->botao_solicitar_agendamento && auth()->user() == null) {
            abort(403);
        }
        $candidato = Candidato::find($candidato);
        $bairrosOrdenados = Candidato::bairros;
        // sort($bairrosOrdenados);

        return view("reforco.solicatacao_confirm")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos"    => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config"    => $config,
            "candidato"    => $candidato ,
        ]);

        

    }

    public function solicitarReforcoForm(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'cpf' => 'required',
            'data_de_nascimento' => 'required|date',
            'data_um' => 'required|date',
            'data_dois' => 'required|date',
        ]);
        $datetime1 = new DateTime(now());
        $datetime2 = new DateTime($request->data_dois);

        $difference = $datetime1->diff($datetime2);
        $request->session()->forget('status');
        if($difference->m < 6){
            // $request->session()->flash('status', 'Intervalo entre a segunda dose ainda não completou 6 meses!');
            return redirect()->back()->with([
                "status" => "Intervalo entre a segunda dose ainda não completou 6 meses!."
            ]);
            dd("teste");
        }
        // dd("passou");
        $request->session()->put('validate', $validate);

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais   =  Etapa::where('atual', true)->orderBy('texto')->get();
        $config = Configuracao::first();

        // if ($config->botao_solicitar_agendamento && auth()->user() == null) {
        //     abort(403);
        // }
        $bairrosOrdenados = Candidato::bairros;

        return view("reforco.form_dose_tres")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos"    => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config"    => $config,
            "validate"    => $validate,
        ]);

    }
}
