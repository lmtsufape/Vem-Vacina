<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDose extends Model
{
    use HasFactory;
    protected $fillable = ['data_um', 'data_dois'];
    protected $casts = [
        'data_um' => 'datetime',
        'data_dois' => 'datetime',
    ];

    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

}
