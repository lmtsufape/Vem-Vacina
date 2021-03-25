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
}
