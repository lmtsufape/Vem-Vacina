<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\LotePostoVacinacao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidato extends Model
{
    use HasFactory, Notifiable, SoftDeletes;


    public const SEXO_ENUM = ["Masculino", "Feminino", "Não informar"];
    public const APROVACAO_ENUM = ["Não Analisado", "Aprovado", "Reprovado", "Vacinado"];
    public const DOSE_ENUM = ["1ª Dose", '2ª Dose', "Dose única", "3ª Dose", "4ª Dose"];
    public const bairros = [
        "Área rural",
        "Aloísio Pinto",
        "Boa Vista",
        "Distrito Iratama",
        "Distrito Miracica",
        "Distrito São Pedro",
        "Dom Hélder Câmara",
        "Dom Thiago Postma",
        "Francisco Figueira",
        "Heliópolis",
        "José Maria Dourado",
        "Magano",
        "Manoel Chéu",
        "Novo Heliópolis",
        "Santo Antônio",
        "Severiano Moraes Filho",
        "São José",
    ];


    protected $fillable = [
        "nome_completo",
        "data_de_nascimento",
        "cpf",
        "numero_cartao_sus",
        "sexo",
        "nome_da_mae",
        "telefone",
        "whatsapp",
        "email",
        "cep",
        "cidade",
        "bairro",
        "logradouro",
        "numero_residencia",
        "complemento_endereco",
        "chegada",
        "saida",
        "lote_id",
        "posto_vacinacao_id",
        "etapa_id",
        "etapa_resultado",
        "dose",
        "doses",
        "dose_id",
        // "profissional_da_saude",
        // "pessoa_idosa",
    ];

    protected $casts = [
        'chegada' => 'datetime',
    ];

    public function etapa()
    {
        return $this->belongsTo(Etapa::class, 'etapa_id');
    }

    public function getWhatsapp()
    {
        $array = array("(", ")", "-", " ");
        return str_replace($array, "", $this->whatsapp);
    }

    public function getMessagemWhatsapp()
    {
        $mensagem = "";
        if ($this->aprovacao == $this::APROVACAO_ENUM[0]) {
            $mensagem = "Sr(a). " . $this->nome_completo . ",\n";
            $mensagem = $mensagem . "Informamos que a sua solicitação de agendamento para vacinação foi para a fila de espera, aguarde o contato da Secretaria Municipal de Saúde de Garanhuns - PE.\n";
            $mensagem = $mensagem . "Para que seja realizada a aplicação da vacina, é preciso apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência no nome da pessoa a ser vacinada. Para os agendamentos de pessoas com comorbidades é necessária a apresentação do formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde (exceto pessoas com Síndrome de Down).\n";
            $mensagem = $mensagem . "Reforçamos a importância de que o idoso esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada.\n";
            $mensagem = $mensagem . "Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!";
        } else if ($this->aprovacao == $this::APROVACAO_ENUM[1]) {
            $mensagem = "Sr(a). " . $this->nome_completo . ",\n";
            $mensagem = $mensagem . "a sua solicitação de agendamento para vacinação foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE.\n\n";
            $mensagem = $mensagem . "A seguir, encontram-se o dia, horário e local de aplicação da " . $this->dose . ":\n\n";
            $mensagem = $mensagem . "Dia: " . date('d/m/Y \à\s  H:i\h', strtotime($this->chegada)) . ".\n";
            $mensagem = $mensagem . "Local: " . $this->posto->nome . ".\n";
            $mensagem = $mensagem . "Endereço: " . $this->posto->endereco . ".\n\n";
            $mensagem = $mensagem . "Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência constando o nome da pessoa a ser vacinada.\n\n";
            $mensagem = $mensagem . "Para os agendamentos de comorbidades é necessário o formulário que atesta a comorbidade, preenchido por um profissional de saúde.\n\n";
            $mensagem = $mensagem . "No caso de menores de 18 anos deve ser apresentado documento de identificação com foto ou certidão de nascimento, CPF, cartão do SUS e comprovante de residência constando o nome dos pais ou responsável legal.\n\n";
            $mensagem = $mensagem . "IMPORTANTE: No momento da vacinação o adolescente deve estar acompanhado dos pais. No caso de responsável legal, a condição de tutela deve ser comprovada através de documento emitido em cartório.\n\n";
            $mensagem = $mensagem . "Reforçamos a importância de que a pessoa esteja de posse de todos os documentos! A pessoa cadastrada será imunizada com a dose disponível, de acordo com o grupo escolhido. Agradecemos a sua atenção!";
        } else if ($this->aprovacao == $this::APROVACAO_ENUM[2]) {
            $mensagem = "Seu agendamento foi reprovado.";
        }

        return urlencode($mensagem);
    }

    public function getMessagemSegundaDose()
    {
        $mensagem = "";
        $mensagem = "Sr(a). " . $this->nome_completo . ", \n\n";
        $mensagem = $mensagem . "Esta é uma mensagem da equipe de vacinação contra a Covid-19 da Secretaria de Saúde de Garanhuns. Estamos realizando a busca ativa de pessoas que ainda não receberam sua segunda dose contra a Covid-19,com o intuito de garantir que a população tenha o seu esquema vacinal completo.\n";
        $mensagem = $mensagem . "Se você ainda não recebeu sua segunda dose, pedimos que por favor, responda essa mensagem com o seu nome completo e foto do cartão de vacina entregue após a primeira dose. Caso já tenha recebido a segunda dose, você pode desconsiderar esta mensagem. \n\n";
        $mensagem = $mensagem . "*Campanha de Vacinação contra a Covid-19* \n";
        $mensagem = $mensagem . "*Setor de Agendamento* \n";
        $mensagem = $mensagem . "*(87) 3762-1252 / 9 8835-4998*  \n";
        // $mensagem = $mensagem."A seguir, encontram-se o dia, horário e local de aplicação da ".$this->dose.":\n";
        // $mensagem = $mensagem."Dia: ".date('d/m/Y \à\s  H:i\h', strtotime($this->chegada)).".\n";
        // $mensagem = $mensagem."Local: ".$this->posto->nome.".\n";
        // $mensagem = $mensagem."Endereço: ".$this->posto->endereco.".\n";
        // $mensagem = $mensagem."Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência constando o nome da pessoa a ser vacinada.\n";
        // $mensagem = $mensagem."Para os agendamentos de comorbidades é necessário o formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde (exceto pessoas com Síndrome de Down).\n";
        // $mensagem = $mensagem."Os demais grupos prioritários deverão comprovar esta condição através um destes documentos: declaração de vínculo profissional, contracheque, ou outro documento que comprove o exercício da função e/ou vinculação com o serviço.\n";
        // $mensagem = $mensagem."Reforçamos a importância de que a pessoa esteja de posse de todos os documentos! A pessoa cadastrada será imunizada com a dose disponível, de acordo com o grupo escolhido, não sendo permitida a escolha de outro grupo no ato da vacinação. Agradecemos a sua atenção!";

        return urlencode($mensagem);
    }

    public function getMessagemDoseReforco()
    {
        $mensagem = "";
        $mensagem = "Sr(a). " . $this->nome_completo . ",\n";
        $mensagem = $mensagem . "a sua solicitação de agendamento para vacinação foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE.\n\n";
        $mensagem = $mensagem . "A seguir, encontram-se o dia, horário e local de aplicação da DOSE DE REFORÇO:\n\n";
        $mensagem = $mensagem . "Dia: " . date('d/m/Y \à\s  H:i\h', strtotime($this->chegada)) . ".\n";
        $mensagem = $mensagem . "Local: " . $this->posto->nome . ".\n";
        $mensagem = $mensagem . "Endereço: " . $this->posto->endereco . ".\n\n";
        $mensagem = $mensagem . "Neste momento serão contemplados pessoas acima de 18 anos de idade com quatro meses da segunda dose e imunossuprimidos que completaram o esquema vacinal há pelo menos 28 dias.\n\n";
        $mensagem = $mensagem . "A Secretaria de Saúde vai exigir a apresentação de documento oficial com foto, CPF, cartão do SUS (CNS), comprovante de residência no nome da pessoa que será vacinada, e cartão de vacina Covid-19 com a 2ª dose (D2) ou dose única. Para os imunossuprimidos também será obrigatório o laudo médico ou receita de medicamentos imunossupressores. Os trabalhadores de saúde devem apresentar declaração de vínculo da instituição onde atua em Garanhuns.\n\n";
        $mensagem = $mensagem . "Reforçamos a importância de que você esteja de posse de todos os documentos! Agradecemos a sua atenção!";
        return urlencode($mensagem);
    }

    public function getMessagemDoseDomicilio()
    {
        $mensagem = "";
        $mensagem = "Sr(a). " . $this->nome_completo . ",\n";
        $mensagem = $mensagem . "a sua solicitação de agendamento para vacinação foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE.\n\n";
        $mensagem = $mensagem . "A seguir, encontram-se o dia, horário e local de aplicação da vacina (A vacina para crianças de seis meses a dois anos de idade com comorbidades será realizada, inicialmente, em domicílio):\n\n";
        $mensagem = $mensagem . "Local: " . $this->posto->nome . ".\n";
        $mensagem = $mensagem . "Endereço: " . $this->bairro . ', Rua ' . $this->logradouro . ', N° ' . $this->numero_residencia . ".\n\n";
        $mensagem = $mensagem . "A Secretaria de Saúde solicita a apresentação de documento oficial com foto e CPF dos pais ou responsáveis; cartão do SUS (CNS), cartão de vacina da criança, laudo médico indicando a comorbidade, além da presença do pai ou responsável legal no ato da vacinação.\n\n";
        $mensagem = $mensagem . "Reforçamos a importância de que os pais/mães estejam de posse de todos os documentos! \n\n";
        $mensagem = $mensagem . "Agradecemos a sua atenção!";
        return urlencode($mensagem);
    }

    public function posto()
    {
        return $this->belongsTo(PostoVacinacao::class, 'posto_vacinacao_id');
    }

    public function lote()
    {
        return $this->belongsTo(LotePostoVacinacao::class, 'lote_id');
    }

    public function getDose()
    {
        return $this->belongsTo(Dose::class, 'dose_id');
    }


    public function data_de_nascimento_dmY()
    {
        return (new Carbon($this->data_de_nascimento))->format("d/m/Y");
    }

    public function resultado()
    {
        return $this->belongsTo(OpcoesEtapa::class, 'etapa_resultado');
    }

    public function outrasInfo()
    {
        return $this->belongsToMany(OutrasInfoEtapa::class, 'agendamento_outras_infos', 'candidato_id', 'outras_info_id');
    }

    public function dataDose()
    {
        return $this->hasOne(DataDose::class);
    }
}
