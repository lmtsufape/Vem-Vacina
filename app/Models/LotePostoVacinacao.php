<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LotePostoVacinacao extends Pivot
{
    public $incrementing = true;

    public function posto()
    {
        return $this->belongsTo(PostoVacinacao::class, 'posto_vacinacao_id');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }
}
