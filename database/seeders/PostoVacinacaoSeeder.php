<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostoVacinacao;

class PostoVacinacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        PostoVacinacao::create([
            'nome' => 'Escola CAIC',
            'endereco' => 'Rua 1',
                
        ]);

        PostoVacinacao::create([
            'nome' => 'Centro Cultural',
            'endereco' => 'Rua 1',
            
        ]);

        PostoVacinacao::create([
            'nome' => 'Academia da Saúde Cohab 2',
            'endereco' => 'Rua 1',
            
        ]);

        PostoVacinacao::create([
            'nome' => 'Academia da Saúde Brasília',
            'endereco' => 'Rua 1',
            
        ]);

        PostoVacinacao::create([
            'nome' => 'CESMUC',
            'endereco' => 'Rua 1',
            
        ]);
    }
}
