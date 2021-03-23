<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostoVacinacao;
use Illuminate\Support\Facades\DB;

class PostoVacinacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Escola CAIC',
            'endereco' => 'Rua 1',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,


            "inicio_atendimento_manha" => 9,
            "intervalo_atendimento_manha" => 30,
            "fim_atendimento_manha" => 12,

            "inicio_atendimento_tarde" => 14,
            "intervalo_atendimento_tarde" => 30,
            "fim_atendimento_tarde" => 16,

            "funciona_domingo" => false,
            "funciona_segunda" => true,
            "funciona_terca" => true,
            "funciona_quarta" => true,
            "funciona_quinta" => true,
            "funciona_sexta" => true,
            "funciona_sabado" => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Centro Cultural',
            'endereco' => 'Rua 1',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,


            "inicio_atendimento_manha" => 9,
            "intervalo_atendimento_manha" => 30,
            "fim_atendimento_manha" => 12,

            "inicio_atendimento_tarde" => 14,
            "intervalo_atendimento_tarde" => 30,
            "fim_atendimento_tarde" => 16,

            "funciona_domingo" => false,
            "funciona_segunda" => true,
            "funciona_terca" => true,
            "funciona_quarta" => true,
            "funciona_quinta" => true,
            "funciona_sexta" => true,
            "funciona_sabado" => false,

        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Academia da Saúde Cohab 2',
            'endereco' => 'Rua 1',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,


            "inicio_atendimento_manha" => 9,
            "intervalo_atendimento_manha" => 30,
            "fim_atendimento_manha" => 12,

            "inicio_atendimento_tarde" => 14,
            "intervalo_atendimento_tarde" => 30,
            "fim_atendimento_tarde" => 16,

            "funciona_domingo" => false,
            "funciona_segunda" => true,
            "funciona_terca" => true,
            "funciona_quarta" => true,
            "funciona_quinta" => true,
            "funciona_sexta" => true,
            "funciona_sabado" => false,

        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Academia da Saúde Brasília',
            'endereco' => 'Rua 1',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,


            "inicio_atendimento_manha" => 9,
            "intervalo_atendimento_manha" => 30,
            "fim_atendimento_manha" => 12,

            "inicio_atendimento_tarde" => 14,
            "intervalo_atendimento_tarde" => 30,
            "fim_atendimento_tarde" => 16,

            "funciona_domingo" => false,
            "funciona_segunda" => true,
            "funciona_terca" => true,
            "funciona_quarta" => true,
            "funciona_quinta" => true,
            "funciona_sexta" => true,
            "funciona_sabado" => false,

        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'CESMUC',
            'endereco' => 'Rua 1',
            'para_idoso' => false,
            'para_profissional_da_saude' => false,


            "inicio_atendimento_manha" => 9,
            "intervalo_atendimento_manha" => 30,
            "fim_atendimento_manha" => 12,

            "inicio_atendimento_tarde" => 14,
            "intervalo_atendimento_tarde" => 30,
            "fim_atendimento_tarde" => 16,

            "funciona_domingo" => false,
            "funciona_segunda" => true,
            "funciona_terca" => true,
            "funciona_quarta" => true,
            "funciona_quinta" => true,
            "funciona_sexta" => true,
            "funciona_sabado" => false,

        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => ' Drive thru ',
            'endereco' => 'Rua 1(Na secretaria de saúde, somente aos sábados pela manhã)',
            'para_idoso' => false,
            'para_profissional_da_saude' => true,


            "inicio_atendimento_manha" => 9,
            "intervalo_atendimento_manha" => 30,
            "fim_atendimento_manha" => 12,

            "funciona_domingo" => false,
            "funciona_segunda" => false,
            "funciona_terca" => false,
            "funciona_quarta" => false,
            "funciona_quinta" => false,
            "funciona_sexta" => false,
            "funciona_sabado" => true,

        ]);
    }
}
