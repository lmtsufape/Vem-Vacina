<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstatisticaKeyCache extends Model
{
    use HasFactory;

    public const TEMPO_DE_CACHE = 1;
    public $fillable = ['dado', 'key'];
}
