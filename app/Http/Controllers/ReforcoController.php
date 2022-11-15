<?php

namespace App\Http\Controllers;

use App\Models\Dose;
use DateTime;
use App\Models\Etapa;
use App\Models\Candidato;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use App\Models\PostoVacinacao;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isEmpty;

class ReforcoController extends Controller
{
    public function index()
    {
        return view('reforco.consultar_cadastro');
    }

    public function index2()
    {
        return view('reforco2.consultar_cadastro');
    }

    public function novaDoseCpf($id)
    {
        $dose = Dose::find($id);
        return view('candidato_dose.consultar_cadastro', compact('id', 'dose'));
    }

    public function verificarDose(Request $request)
    {
        if(isset($request->número_cartão_sus)){
            $request['cpf'] = $request->número_cartão_sus;
        }

        $validate = $request->validate([
            'cpf' => 'required',
            'data_de_nascimento' => 'required|date'
        ]);

        $request->session()->put('validate', $validate);
        $dose = Dose::find($request->dose_id);
        // verificação de dose atual
        if (Candidato::where('cpf', $request->cpf)->where('aprovacao', '!=', Candidato::APROVACAO_ENUM[2])->where('dose_id', $request->dose_id)->
            count() > 0) {
            return redirect()->back()->with([
                "status" => "Existe um agendamento para a " . $dose->nome . " para esse cpf."]);
        }
        // verificação de dose anterior
        if($dose->dose_anterior_id == 0) {
            $candidato = Candidato::where('cpf', $validate['cpf'])->where('dose', '4ª Dose')->where('aprovacao', '!=', Candidato::APROVACAO_ENUM[2])->first();
        }elseif($dose->dose_anterior_id == -1){
            $candidato = Candidato::where('cpf', $validate['cpf'])->orderByDesc('created_at')->first();
        }else {
            $candidato = Candidato::where('cpf', $validate['cpf'])->where('dose_id', $dose->dose_anterior_id)->where('aprovacao','!=', Candidato::APROVACAO_ENUM[2])->first();
        }

        // verificação de cadastro
        //$candidato = Candidato::where('cpf', $validate['cpf'])->where('aprovacao', '!=', Candidato::APROVACAO_ENUM[2])->orderByDesc('created_at')->first();

        if($dose->dose_anterior_id == -1){
            return redirect()->route('solicitacao.reforcoDose',['dose'=>$dose, 'candidato' => $candidato, 'cpf' => $request->cpf, 'numero_cartao_sus' => $request->número_cartão_sus,'data_de_nascimento' => $request->data_de_nascimento]);
        }
        // Verificação para existencia do candidato
        if ($candidato != null) {
            return redirect()->route('solicitacao.reforcoDose', ['candidato' => $candidato, 'dose' => $dose]);
        }
        return view('candidato_dose.data_dose', compact('dose', 'validate'));

    }

    // Passagem de dados para o formulário de doses
    public function solicitarReforcoDose(Request $request)
    {
        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $dose = Dose::find($request->dose);
        $etapasAtuais = [];
        foreach ($dose->etapas as $etapa) {
            if ($etapa->atual) {
                array_push($etapasAtuais, $etapa);
            }
        }
        $config = Configuracao::first();
        $bairrosOrdenados = Candidato::bairros;
        if ($request->candidato != null) {
            $candidato = Candidato::find($request->candidato);
            return view("candidato_dose.solicatacao_confirm")->with([
                "sexos" => Candidato::SEXO_ENUM,
                "postos" => $postos_com_vacina,
                "dose" => $dose->id,
                "publicos" => $etapasAtuais,
                "tipos" => Etapa::TIPO_ENUM,
                "bairros" => $bairrosOrdenados,
                "config" => $config,
                "candidato" => $candidato,
            ]);
        }

        if($dose->dose_anterior_id != -1){
            $validate = $request->validate([
                'cpf' => 'required',
                'data_de_nascimento' => 'required|date',
                'data_dois' => 'required|date',
            ]);
        }else{
            $validate = $request->validate([
                'cpf' => 'required',
                'data_de_nascimento' => 'required|date',
               ]);
        }

        $request->session()->put('validate', $validate);
        if($request->numero_cartao_sus != null){
            return view("candidato_dose.solicatacao_confirm")->with([
                "sexos" => Candidato::SEXO_ENUM,
                "postos" => $postos_com_vacina,
                "dose" => $dose->id,
                "publicos" => $etapasAtuais,
                "tipos" => Etapa::TIPO_ENUM,
                "bairros" => $bairrosOrdenados,
                "config" => $config,
                "validate" => $validate,
                "cpf" => null,
                "numero_cartao_sus" => $request->numero_cartao_sus,
                "data_de_nascimento" => $request->data_de_nascimento,
            ]);
        }

        return view("candidato_dose.solicatacao_confirm")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "dose" => $dose->id,
            "publicos" => $etapasAtuais,
            "tipos" => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config" => $config,
            "validate" => $validate,
            "cpf" => $request->cpf,
            "data_de_nascimento" => $request->data_de_nascimento,
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
        $etapasAtuais = Etapa::where('atual', true)->where('dose_tres', true)->orderBy('texto')->get();
        $config = Configuracao::first();


        $bairrosOrdenados = Candidato::bairros;

        return view("reforco.form_dose_tres")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos" => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config" => $config,
            "validate" => $validate,
        ]);

    }

    public function verificarCadastro(Request $request)
    {
        $validate = $request->validate([
            'cpf' => 'required',
            'data_de_nascimento' => 'required|date',
        ]);

        $request->session()->put('validate', $validate);

        if (Candidato::where('cpf', $validate['cpf'])->where('dose', '3ª Dose')->where('aprovacao', '!=', Candidato::APROVACAO_ENUM[2])
                ->count() > 0) {
            return redirect()->back()->with([
                "status" => "Existe um agendamento para a 3ª dose para esse cpf."
            ]);
        }

        $candidatos = Candidato::where('cpf', $validate['cpf'])
            ->where('data_de_nascimento', $validate['data_de_nascimento'])
            ->orderBy('dose')
            ->take(2)->get();


        if (count($candidatos) > 0) {
            if (Etapa::where('atual', true)->where('dose_tres', true)->where('id', $candidatos[0]->etapa_id)->get()->count() == 0) {
                return redirect()->back()->with([
                    "status" => "Público ou etapa indisponível para a dose de reforço no momento."
                ]);
            }
            return redirect()->route('solicitacao.reforco', ['candidato' => $candidatos[0]->id]);
        } else {
            return view('reforco.data_dose', compact('validate'));
        }
    }

    public function verificarCadastro2(Request $request)
    {
        $validate = $request->validate([
            'cpf' => 'required',
            'data_de_nascimento' => 'required|date',
        ]);

        $request->session()->put('validate', $validate);

        if (Candidato::where('cpf', $validate['cpf'])->where('dose', '4ª Dose')->where('aprovacao', '!=', Candidato::APROVACAO_ENUM[2])
                ->count() > 0) {
            return redirect()->back()->with([
                "status" => "Existe um agendamento para a 4ª dose para esse cpf."
            ]);
        }

        $candidatos = Candidato::where('cpf', $validate['cpf'])
            ->where('data_de_nascimento', $validate['data_de_nascimento'])
            ->where('dose', '3ª Dose')
            ->get();


        if (count($candidatos) > 0) {
            if (Etapa::where('atual', true)->where('dose_quatro', true)->where('id', $candidatos[0]->etapa_id)->get()->count() == 0) {
                return redirect()->back()->with([
                    "status" => "Público ou etapa indisponível para a segunda dose de reforço no momento."
                ]);
            }

            return redirect()->route('solicitacao.reforco2', ['candidato' => $candidatos[0]->id]);
        } else {
            return view('reforco2.data_dose', compact('validate'));
        }
    }

    public function solicitarDoseTres($candidato)
    {

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais = Etapa::where('atual', true)->where('dose_tres', true)->orderBy('texto')->get();
        $config = Configuracao::first();

        $bairrosOrdenados = Candidato::bairros;

        return view("reforco.form_dose_tres")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos" => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config" => $config,
        ]);

    }

    public function solicitarDoseQuatro($candidato)
    {

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais = Etapa::where('atual', true)->where('dose_quatro', true)->orderBy('texto')->get();
        $config = Configuracao::first();

        $bairrosOrdenados = Candidato::bairros;

        return view("reforco.form_dose_quatro")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos" => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config" => $config,
        ]);

    }

    public function solicitarReforco($candidato)
    {
        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais = Etapa::where('atual', true)->where('dose_tres', true)->orderBy('texto')->get();
        $config = Configuracao::first();

        $candidato = Candidato::find($candidato);
        $bairrosOrdenados = Candidato::bairros;

        return view("reforco.solicatacao_confirm")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos" => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config" => $config,
            "candidato" => $candidato,
        ]);


    }

    public function solicitarReforco2($candidato)
    {

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais = Etapa::where('atual', true)->where('dose_quatro', true)->orderBy('texto')->get();
        $config = Configuracao::first();

        $candidato = Candidato::find($candidato);
        $bairrosOrdenados = Candidato::bairros;

        return view("reforco2.solicatacao_confirm")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos" => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config" => $config,
            "candidato" => $candidato,
        ]);


    }

    public function reforcoSolicitaForm2(Request $request)
    {
        $validate = $request->validate([
            'cpf' => 'required',
            'data_de_nascimento' => 'required|date',
            'data_dois' => 'required|date',
        ]);
        $data_agora = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $data_recebida = new DateTime($request->data_dois);


        if ($data_recebida > $data_agora) {
            return redirect()->back()->withErrors([
                "data_dois" => "A data só pode ser anterior ou igual a atual (" . date_format($data_agora, "d/m/Y") . ")"
            ])->withInput();
        }

        $request->session()->put('validate', $validate);

        $postos_com_vacina = PostoVacinacao::where('padrao_no_formulario', true)->get();
        $etapasAtuais = Etapa::where('atual', true)->where('dose_quatro', true)->orderBy('texto')->get();
        $config = Configuracao::first();


        $bairrosOrdenados = Candidato::bairros;

        return view("reforco2.form_dose_quatro")->with([
            "sexos" => Candidato::SEXO_ENUM,
            "postos" => $postos_com_vacina,
            "doses" => Candidato::DOSE_ENUM,
            "publicos" => $etapasAtuais,
            "tipos" => Etapa::TIPO_ENUM,
            "bairros" => $bairrosOrdenados,
            "config" => $config,
            "validate" => $validate,
        ]);

    }
}
