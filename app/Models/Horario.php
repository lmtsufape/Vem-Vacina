<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['horario'];
    protected $casts = [
        'horario' => 'datetime',
    ];

    public function posto()
    {
        return $this->belongsTo(Dia::class, 'dia_id');
    }


}
