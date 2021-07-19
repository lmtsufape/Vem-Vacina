<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcoesEtapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'opcoes',
        'etapa_id',
    ];

    public function candidatos() {
        return $this->hasMany(Candidato::class, 'etapa_resultado');
    }
}
