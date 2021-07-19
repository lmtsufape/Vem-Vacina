<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configuracaos')->insert([
            'botao_solicitar_agendamento' => false,
            'botao_fila_de_espera'        => false,
            'link_do_form_fila_de_espera' => 'Vazio',
        ]);
    }
}
