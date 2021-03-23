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
            'nome' => 'Academia da Saúde (Brasília)',
            'endereco' => 'Rua Barão de São Borges, s/nº',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Academia da Saúde da Cohab II',
            'endereco' => 'Rua Professor Antônio Souto, s/nº',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Centro Cultural Alfredo Leite Cavalcanti',
            'endereco' => 'Entrada pela rua Coronel Antônio Vitor, s/nº, bairro São José',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Escola Municipal Professor Antônio Gonçalves Dias (Caic)',
            'endereco' => 'Rua Ebenezer Furtado Gueiros, s/nº, bairro Severiano Morais FIlho',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Ponto de Vacinação do Cesmuc',
            'endereco' => 'Avenida Afonso Pena, S/n°, bairro São José',
            'para_idoso' => false,
            'para_profissional_da_saude' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Secretaria de Saúde de Garanhuns(Drive-thru)',
            'endereco' => 'Rua Joaquim Távora, s/nº, bairro Heliópolis',
            'para_idoso' => false,
            'para_profissional_da_saude' => false,
        ]);


    }
}
