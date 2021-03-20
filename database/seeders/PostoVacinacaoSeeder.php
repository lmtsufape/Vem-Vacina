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
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Centro Cultural',
            'endereco' => 'Rua 1',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Academia da Saúde Cohab 2',
            'endereco' => 'Rua 1',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Academia da Saúde Brasília',
            'endereco' => 'Rua 1',
            'para_idoso' => true,
            'para_profissional_da_saude' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'CESMUC',
            'endereco' => 'Rua 1',
            'para_idoso' => false,
            'para_profissional_da_saude' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => ' Drive thru ',
            'endereco' => 'Rua 1(Na secretaria de saúde, somente aos sábados pela manhã)',
            'para_idoso' => false,
            'para_profissional_da_saude' => true,
        ]);
    }
}
