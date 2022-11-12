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
        'texto_home',
        'exibir_na_home',
        'exibir_no_form',
        'atual',
        'dose_unica',
        'total_pessoas_vacinadas_pri_dose',
        'total_pessoas_vacinadas_seg_dose',
        'texto_outras_informacoes',
        'intervalo_reforco',
    ];

    protected $casts = [
        'intervalo_reforco' => 'datetime',
    ];

    public function candidatos() {
        return $this->hasMany(Candidato::class, 'etapa_id');
    }

    public function opcoes() {
        return $this->hasMany(OpcoesEtapa::class, 'etapa_id');
    }

    public function pontos() {
        return $this->belongsToMany(PostoVacinacao::class, 'ocorrendo_vacinacaos', 'etapa_id', 'posto_id');
    }

    public function outrasInfo() {
        return $this->hasMany(OutrasInfoEtapa::class, 'etapa_id');
    }

    public function lotes() {
        return $this->belongsToMany(Lote::class, 'lote_etapas', 'etapa_id', 'lote_id');
    }

    public function doses()
    {
        return $this->belongsToMany(Dose::class, 'etapa_dose', 'etapa_id', 'dose_id');
    }
}
