<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpcoesEtapaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    

    public function run()
    {
        $profissao_enum = ["Acadêmico em saúde e estudante da área técnica em saúde em estágio hospitalar, atenção básica, clínica e laboratório", 
                            "Agente comunitário de saúde", "Agente de combate às endemias", "Assistente social", "Biólogo(a)", "Biomédico(a)",
                            "Biomédico(a)", "Cuidador(a) de idoso", "Doulas/parteiras", "Enfermeiro(a)", "Farmacêutico(a)", "Fisioterapeuta", 
                            "Fonoaudiólogo(a)", "Funcionário do sistema funerário", "Funcionário do Instituto Médico Legal (IML)", "Médico(a)",
                            "Médico(a) veterinário(a)", "Nutricionista", "Odontólogo(a)", "Profissional de educação física", "Profissional da vigilância em saúde",
                            "Profissional que atua em programas ou serviços de atendimento domiciliar", "Psicólogo(a)", "Serviço de Verificação de Óbito (SVO)",
                            "Técnicos e auxiliares em geral", "Terapeuta ocupacional", "Trabalhador de apoio geral"];

        foreach ($profissao_enum as $profissao) {
            DB::table('opcoes_etapas')->insert([
                'opcao' => $profissao,
                'etapa_id' => 2,
            ]);
        }
    }
}
