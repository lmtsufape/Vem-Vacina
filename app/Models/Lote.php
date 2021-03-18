<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'qtdVacina',
    ];

    public function postos()
    {
        return $this->belongsToMany(PostoVacinacao::class);
    }
}
