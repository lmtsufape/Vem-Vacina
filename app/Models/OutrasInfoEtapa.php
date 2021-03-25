<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutrasInfoEtapa extends Model
{
    use HasFactory;

    protected $fillable = ['campo', 'etapa_id'];

    public function etapa() {
        return $this->belongsTo(Etapa::class, 'etapa_id');
    }

    public function agendamentos() {
        return $this->belongsToMany(Candidato::class, 'agendamento_outras_infos', 'outras_info_id', 'candidato_id');
    }
}
