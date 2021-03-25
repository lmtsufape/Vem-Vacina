<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero_lote',
        'fabricante',
        'numero_vacinas',
        'dose_unica',
        'inicio_periodo',
        'fim_periodo',
        'data_fabricacao',
        'data_validade',
    ];

    public function postos()
    {
        return $this->belongsToMany(PostoVacinacao::class, 'lote_posto_vacinacao', 'lote_id', 'posto_vacinacao_id')
                    ->withPivot('id','qtdVacina');
    }

    public function candidatos()
    {
        return $this->hasMany(Candidato::class, 'lote_id');
    }

    public function etapas()
    {
        return $this->belongsToMany(Etapa::class, 'lote_etapas', 'lote_id', 'etapa_id');
    }
}
