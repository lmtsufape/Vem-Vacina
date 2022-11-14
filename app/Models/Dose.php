<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dose extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'dose_anterior_id',
        'exibir_home',
        'desabilitar_cpf'
    ];

    public function etapas()
    {
        return $this->belongsToMany(Etapa::class, 'etapa_dose');
    }

    public function candidatos()
    {
        return $this->hasMany(Candidato::class, 'dose_id');
    }

}
