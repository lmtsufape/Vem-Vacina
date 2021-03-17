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
        for ($i = 1; $i <= 10; $i++) {
            DB::table('candidatos')->insert([  //
                'nome_completo' => 'candidado'.$i,
                'data_de_nascimento' => Carbon::now(),
                'cpf' => '123.123.123-25',
                'numero_cartao_sus' => '12345678',
                'sexo' => "Masculino",
                'nome_da_mae' => 'NomeDaMae'.$i,
                'foto_frente_rg' => 'teste_frente.jpeg',
                'foto_tras_rg' => 'teste_tras.jpeg',
                'paciente_acamado' => true,
                'paciente_agente_de_saude' => false,
                'unidade_caso_agente_de_saude' => '',
                'telefone' => '(87) 99999-9999',
                'whatsapp' => '(87) 99999-9999',
                'email' => 'teste'.$i.'@teste',
                'cep' => 55123000,
                'cidade' => 'cidade'.$i,
                'bairro' => 'bairro'.$i,
                'logradouro' => 'logradouro'.$i,
                'numero_residencia' => $i,
                'complemento_endereco' => 'Casa',
                'hora_chegada' => '14:00',
                'hora_saida' => '14:10',
                'lote_id' => null,
                'posto_vacinacao_ìd' => 1,
                'lote_id' => 1,
                'posto_vacinacao_ìd' => 1
            ]);
        }
    }
}
