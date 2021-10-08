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
        return view('reforco.consultar_cadastro');
    }

    public function verificarCadastro(Request $request)
    {
        $validate = $request->validate([
            'cpf' => 'required',
            'data_de_nascimento' => 'required|date',
        ]);

        $request->session()->put('validate', $validate);

        if (Candidato::where('cpf', $validate['cpf'])->where('dose', '3ª Dose')->where('aprovacao','!=', Candidato::APROVACAO_ENUM[2])
                    ->count() > 0) {
                    return redirect()->back()->with([
                            "status" => "Existe um agendamento para a 3ª dose para esse cpf."
            ]);
        }
        
        $candidatos = Candidato::where('cpf', $validate['cpf'])
                                ->where('data_de_nascimento', $validate['data_de_nascimento'])
                                ->orderBy('dose')
                                ->take(2)->get();
                                
                                
        if (count($candidatos) > 0 ) {
            if (Etapa::where('atual', true)->where('dose_tres', true)->where('id', $candidatos[0]->etapa_id)->get()->count() == 0) {
                        return redirect()->back()->with([
                                                        "status" => "Público ou etapa indisponível para a dose de reforço no momento."
                                                        ]);
            }
            return redirect()->route('solicitacao.reforco',[ 'candidato' => $candidatos[0]->id]);
        }else{
            return view('reforco.data_dose', compact('validate'));
        }
    }

    public function solicitarDoseTres($candidato) {

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais   =  Etapa::where('atual', true)->where('dose_tres', true)->orderBy('texto')->get();
        $config = Configuracao::first();

        $bairrosOrdenados = Candidato::bairros;

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
        $etapasAtuais   =  Etapa::where('atual', true)->where('dose_tres', true)->orderBy('texto')->get();
        $config = Configuracao::first();
        
        $candidato = Candidato::find($candidato);
        $bairrosOrdenados = Candidato::bairros;
        
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

    public function reforcoSolicitaForm(Request $request)
    {
        $validate = $request->validate([
            'cpf' => 'required',
            'data_de_nascimento' => 'required|date',
            'data_um' => 'required|date',
            'data_dois' => 'required|date',
        ]);
        
        $request->session()->put('validate', $validate);

        

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais   =  Etapa::where('atual', true)->where('dose_tres', true)->orderBy('texto')->get();
        $config = Configuracao::first();

       
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
