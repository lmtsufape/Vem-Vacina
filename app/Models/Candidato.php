<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidato extends Model
{
    use HasFactory,  Notifiable, SoftDeletes;


    public const SEXO_ENUM = ["Masculino", "Feminino", "Não informar"];
    public const APROVACAO_ENUM = ["Não Analisado", "Aprovado", "Reprovado", "Vacinado"];
    public const DOSE_ENUM = ["1ª Dose", '2ª Dose', "Dose única"];
    public const bairros = [
        "Magano",
        "Dom Hélder Câmara",
        "Dom Thiago Postma",
        "São José",
        "Santo Antônio",
        "Aloísio Pinto",
        "Boa Vista",
        "Francisco Figueira",
        "Heliópolis",
        "José Maria Dourado",
        "Novo Heliópolis",
        "Severiano Moraes Filho",
        "Manoel Chéu",
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
        // "profissional_da_saude",
        // "pessoa_idosa",
    ];

    protected $casts = [
        'chegada' => 'datetime',
    ];

    public function etapa() {
        return $this->belongsTo(Etapa::class, 'etapa_id');
    }

    public function getWhatsapp()
    {
        $array =  array("(", ")", "-", " ");
        return str_replace($array, "", $this->whatsapp);
    }

    public function getMessagemWhatsapp() {
        $mensagem = "";
        if ($this->aprovacao == $this::APROVACAO_ENUM[0]) {
            $mensagem = "Sr(a). ".$this->nome_completo.",\n";
            $mensagem = $mensagem."Informamos que a sua solicitação de agendamento para vacinação foi para a fila de espera, aguarde o contato da Secretaria Municipal de Saúde de Garanhuns - PE.\n";
            $mensagem = $mensagem."Lembramos que para que seja realizada a aplicação da vacina, o idoso deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência.\n";
            $mensagem = $mensagem."Reforçamos a importância de que o idoso esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada.\n";
            $mensagem = $mensagem."Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!";
        } else if ($this->aprovacao == $this::APROVACAO_ENUM[1]) {
            $mensagem = "Sr(a). ".$this->nome_completo.",\n";
            $mensagem = $mensagem."Informamos que a sua solicitação de agendamento para vacinação foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE.\n";
            $mensagem = $mensagem."A seguir, encontram-se o dia, horário e local de aplicação da ".$this->dose.":\n";
            $mensagem = $mensagem."Dia: ".date('d/m/Y \à\s  H:i\h', strtotime($this->chegada)).".\n";
            $mensagem = $mensagem."Local: ".$this->posto->nome.".\n";
            $mensagem = $mensagem."Endereço: ".$this->posto->endereco.".\n";
            $mensagem = $mensagem."Lembramos que para que seja realizada a aplicação da vacina, o idoso deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência.\n";
            $mensagem = $mensagem."Reforçamos a importância de que o idoso esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada.\n";
            $mensagem = $mensagem."Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!";
        } else if ($this->aprovacao == $this::APROVACAO_ENUM[2]) {
            $mensagem = "Seu agendamento foi reprovado.";
        }
        
        return urlencode($mensagem);
    }

    public function posto() {
        return $this->belongsTo(PostoVacinacao::class, 'posto_vacinacao_id');
    }

    public function lote() {
        return $this->belongsTo(Lote::class, 'lote_id');
    }


    public function data_de_nascimento_dmY() {
        return (new Carbon($this->data_de_nascimento))->format("d/m/Y");
    }

    public function resultado() {
        return $this->belongsTo(OpcoesEtapa::class, 'etapa_resultado');
    }

    public function outrasInfo() {
        return $this->belongsToMany(OutrasInfoEtapa::class, 'agendamento_outras_infos', 'candidato_id', 'outras_info_id');
    }
}
