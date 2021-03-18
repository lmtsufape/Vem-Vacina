<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;
    
    public const SEXO_ENUM = ["Masculino", "Feminino"];
    public const APROVACAO_ENUM = ["Não Analisado", "Aprovado", "Reprovado"];

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



    
}
