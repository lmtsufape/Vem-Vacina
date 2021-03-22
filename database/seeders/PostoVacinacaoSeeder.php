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
            'padrao_no_formulario' => true,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Centro Cultural',
            'endereco' => 'Rua 1',
            'padrao_no_formulario' => true,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Academia da Saúde Cohab 2',
            'endereco' => 'Rua 1',
            'padrao_no_formulario' => true,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'Academia da Saúde Brasília',
            'endereco' => 'Rua 1',
            'padrao_no_formulario' => true,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => 'CESMUC',
            'endereco' => 'Rua 1',
            'padrao_no_formulario' => false,
        ]);

        DB::table('posto_vacinacaos')->insert([
            'nome' => ' Drive thru ',
            'endereco' => 'Rua 1(Na secretaria de saúde, somente aos sábados pela manhã)',
            'padrao_no_formulario' => false,
        ]);
    }
}
