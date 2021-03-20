<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostoVacinacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'endereco'];



    public function lotes()
    {
        return $this->belongsToMany(Lote::class, 'lote_posto_vacinacao',  'posto_vacinacao_id', 'lote_id')
                    ->withPivot('qtdVacina');;
    }

    public function getVacinasDisponivel()
    {
        $totalVacinas = null;
        foreach ($this->lotes->all() as $key => $value) {
            $totalVacinas += $value->pivot->qtdVacina;
        }
        return $totalVacinas;
    }
}
