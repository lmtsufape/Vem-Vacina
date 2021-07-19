<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidato;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CandidatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Candidato::factory()->times(20000)->create();
        // $chegada = new Carbon("19-03-2021 09:00:00");
        // $saida = new Carbon("19-03-2021 09:10:00");

        // for ($i = 1; $i <= 10; $i++) {
        //     DB::table('candidatos')->insert([  //
        //         'nome_completo' => 'candidado candidado candidado'.$i,
        //         'data_de_nascimento' => Carbon::now(),
        //         'cpf' => '123.123.123-25',
        //         'numero_cartao_sus' => '8980037254390',
        //         'sexo' => "Masculino",
        //         'nome_da_mae' => 'NomeDaMae'.$i,
        //         // 'paciente_acamado' => true,
        //         'telefone' => '(87) 99999-9999',
        //         'whatsapp' => '(87) 99999-9999',
        //         'email' => 'gabriel.antonio.dev@gmail.com',
        //         'cep' => 55123000,
        //         'cidade' => 'cidade'.$i,
        //         'bairro' => 'bairro'.$i,
        //         'logradouro' => 'logradouro'.$i,
        //         'numero_residencia' => $i,
        //         'complemento_endereco' => 'Casa',
        //         'aprovacao' => "Aprovado",
        //         'chegada' => $chegada,
        //         'saida' => $saida,
        //         'lote_id' => null,
        //         'posto_vacinacao_id' => 1,
        //         'lote_id' => 1,
        //         // 'profissional_da_saude' => Candidato::PROFISSAO_ENUM[$i],
        //         // 'pessoa_idosa'  => true,
        //         'etapa_id'      => 1,
        //         'etapa_resultado' => null,
        //     ]);

        //     $chegada->addMinutes(10);
        //     $saida->addMinutes(10);

        // }
    }
}
