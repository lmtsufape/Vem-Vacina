<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['dia'];
    protected $casts = [
        'dia' => 'datetime',
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'dia_id');
    }

    public function posto()
    {
        return $this->belongsTo(PostoVacinacao::class, 'posto_vacinacao_id');
    }
}
