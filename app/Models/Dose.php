<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dose extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'dose_anterior_id',
    ];

    public function etapas()
    {
        return $this->belongsToMany(Etapa::class, 'etapa_dose');
    }

}
