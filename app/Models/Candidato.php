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
    public const DOSE_ENUM = ["1ª Dose", '2ª Dose', "Dose única"];

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
        "foto_frente_rg",
        "foto_tras_rg",
        "lote_id",
        "posto_vacinacao_id",
        "etapa_id",
        "dose"
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

    public function posto() {
        return $this->belongsTo(PostoVacinacao::class, 'posto_vacinacao_id');
    }

    public function lote() {
        return $this->belongsTo(Lote::class, 'lote_id');
    }

}
