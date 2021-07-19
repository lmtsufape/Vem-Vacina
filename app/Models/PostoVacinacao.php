<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PostoVacinacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'endereco', 'padrao_no_formulario'];



    public function lotes()
    {
        return $this->belongsToMany(Lote::class, 'lote_posto_vacinacao',  'posto_vacinacao_id', 'lote_id')
                    ->withPivot('id','qtdVacina');;
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

    public function getCandidatosPorLote($lote_id, $posto_id)
    {
        if ($this->lotes->find($lote_id)) {
            return Candidato::where("lote_id", $lote_id)->where("posto_vacinacao_id", $posto_id)->count();
        }
        return null;

    }

    public function getVacinasDisponivel($lote_id, $posto_id)
    {
        return $this->getVacinasDeLote($lote_id) - $this->getCandidatosPorLote($lote_id, $posto_id);
    }

    public function etapas() {
        return $this->belongsToMany(Etapa::class, 'ocorrendo_vacinacaos', 'posto_id', 'etapa_id');
    }

    public function candidatos()
    {
        return $this->hasMany(Candidato::class);
    }

    public function dias()
    {
        return $this->hasMany(Dia::class, 'posto_vacinacao_id');
    }
}
