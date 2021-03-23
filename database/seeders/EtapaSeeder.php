<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etapa;
use Illuminate\Support\Facades\DB;

class EtapaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('etapas')->insert([
            'inicio_intervalo' => 75,
            'fim_intervalo'    => 79,
            'texto'            => "Pessoa idosa(75 à 79 anos)",
            'tipo'             => Etapa::TIPO_ENUM[0],
            'texto_home'       => "pessoas idosas(75 à 79 anos)",
            'exibir_na_home'   => true,
            'exibir_no_form'   => true,
            'atual'            => true,
            'total_pessoas_vacinadas_pri_dose' => 0,
            'total_pessoas_vacinadas_seg_dose' => 0,
        ]);

        DB::table('etapas')->insert([
            'inicio_intervalo' => null,
            'fim_intervalo'    => null,
            'texto'            => 'Profissional da saúde',
            'tipo'             => Etapa::TIPO_ENUM[2],
            'texto_home'       => 'Profissionais da saúde',
            'exibir_na_home'   => true,
            'exibir_no_form'   => true,
            'atual'            => true,
            'total_pessoas_vacinadas_pri_dose' => 0,
            'total_pessoas_vacinadas_seg_dose' => 0,
        ]);
    }
}
