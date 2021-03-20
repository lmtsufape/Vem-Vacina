<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'inicio_intervalo',
        'fim_intervalo',
        'atual',
        'dose_unica',
        'total_pessoas_vacinadas_pri_dose',
        'total_pessoas_vacinadas_seg_dose',
    ];

    public function candidatos() {
        return $this->hasMany(Candidato::class, 'etapa_id');
    }
}
