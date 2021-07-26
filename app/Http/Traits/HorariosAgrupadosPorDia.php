<?php

namespace App\Http\Traits;

use App\Models\PostoVacinacao;

trait HorariosAgrupadosPorDia {
    public function horarios($posto_id) {

        set_time_limit(40);

        $posto = PostoVacinacao::find($posto_id);

        $postoDias = $posto->dias->sort()->whereBetween('dia', [now(), now()->addDays(7)]);

        $horarios_agrupados_por_dia = [];
        foreach ($postoDias as $key => $value) {
            $key = date_format($value->dia, "d/m/Y");
            if($value->horarios->count()){
                $horarios_agrupados_por_dia[$key] = $value->horarios->pluck('horario');
            }
        }
        return $horarios_agrupados_por_dia;

    }
}
