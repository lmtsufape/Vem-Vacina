<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutrasInfoEtapaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('outras_info_etapas')->insert([
            'campo' => 'Idoso acamado',
            'etapa_id' => 1,
        ]);

        DB::table('outras_info_etapas')->insert([
            'campo' => 'Idoso com dificuldade de locomoção',
            'etapa_id' => 1,
        ]);
    }
}
