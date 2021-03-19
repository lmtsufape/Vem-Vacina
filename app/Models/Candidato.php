<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Candidato extends Model
{
    use HasFactory,  Notifiable;

    public const SEXO_ENUM = ["Masculino", "Feminino"];
    public const APROVACAO_ENUM = ["Não Analisado", "Aprovado", "Reprovado", "Vacinado"];

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
        "hora_chegada",
        "hora_saida",
        "lote_id",
        "posto_vacinacao_ìd",
    ];

    public function etapa() {
        return $this->belongsTo(Etapa::class, 'etapa_id');
    }

    public function getWhatsapp()
    {
        $array =  array("(", ")", "-", " ");
        return str_replace($array, "", $this->whatsapp);
    }

}
