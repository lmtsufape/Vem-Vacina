<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etapa extends Model
{
    use HasFactory, SoftDeletes;

    public const TIPO_ENUM = ["Idade", "Texto", "Texto_opcao", "Total"];

    protected $fillable = [
        'inicio_intervalo',
        'fim_intervalo',
        'texto',
        'tipo',
        'atual',
        'dose_unica',
        'total_pessoas_vacinadas_pri_dose',
        'total_pessoas_vacinadas_seg_dose',
    ];

    public function candidatos() {
        return $this->belongsToMany(Candidato::class, 'agendados', 'etapa_id', 'candidato_id')->withPivot('opcao_etapa_id');
    }

    public function opcoes() {
        return $this->hasMany(OpcoesEtapa::class, 'etapa_id');
    }

    public function pontos() {
        return $this->belongsToMany(PostoVacinacao::class, 'ocorrendo_vacinacaos', 'etapa_id', 'posto_id');
    }
}
