<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostoVacinacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'endereco', 'para_idoso', 'para_profissional_da_saude'];



    public function lotes()
    {
        return $this->belongsToMany(Lote::class, 'lote_posto_vacinacao',  'posto_vacinacao_id', 'lote_id')
                    ->withPivot('qtdVacina');;
    }



    public function addVacinaEmLote($lote_id, $qtd)
    {
        if ($this->lotes->find($lote_id)) {
            $this->lotes->find($lote_id)->pivot->qtdVacina += $qtd;
            $this->lotes->find($lote_id)->pivot->save();
            return $this->lotes->find($lote_id)->pivot->qtdVacina;
        }
        return null;
    }

    public function subVacinaEmLote($lote_id, $qtd)
    {
        if ($this->lotes->find($lote_id)) {
            $this->lotes->find($lote_id)->pivot->qtdVacina -= $qtd;
            $this->lotes->find($lote_id)->pivot->save();
            return $this->lotes->find($lote_id)->pivot->qtdVacina;
        }
        return null;
    }

    public function getVacinasDeLote($lote_id)
    {
        if ($this->lotes->find($lote_id)) {
            return $this->lotes->find($lote_id)->pivot->qtdVacina;
        }
        return null;
    }

    public function getCandidatosPorLote($lote_id)
    {
        if ($this->lotes->find($lote_id)) {
            return $this->lotes()->find($lote_id)->candidatos()->count();
        }
        return null;

    }

    public function getVacinasDisponivel($lote_id)
    {
        return $this->getVacinasDeLote($lote_id) - $this->getCandidatosPorLote($lote_id);
    }
}
