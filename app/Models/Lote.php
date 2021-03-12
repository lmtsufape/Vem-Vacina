<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    public function postos()
    {
        return $this->belongsToMany(PostoVacinacao::class);
    }
}
