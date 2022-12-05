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
            'nome' => 'Academia da Saúde da Cohab II',
            'endereco' => 'Rua Professor Antônio Souto, s/nº',
            'padrao_no_formulario' => false,

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
            'nome' => 'Centro Cultural Alfredo Leite Cavalcanti',
            'endereco' => 'Entrada pela rua Coronel Antônio Vitor, s/nº, bairro São José',
            'padrao_no_formulario' => false,

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
            'nome' => 'Escola Municipal Professor Antônio Gonçalves Dias (Caic)',
            'endereco' => 'Rua Ebenezer Furtado Gueiros, s/nº, bairro Severiano Morais FIlho',
            'padrao_no_formulario' => false,

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
            'nome' => 'Ponto de Vacinação do Cesmuc',
            'endereco' => 'Avenida Afonso Pena, S/n°, bairro São José',
            'padrao_no_formulario' => false,

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
            'nome' => 'Secretaria de Saúde de Garanhuns(Drive-thru)',
            'endereco' => 'Rua Joaquim Távora, s/nº, bairro Heliópolis',
            'padrao_no_formulario' => false,

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

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Domicílio',
            'endereco' => 'Endereço do candidato',
            'padrao_no_formulario' => false,

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

    }
}
