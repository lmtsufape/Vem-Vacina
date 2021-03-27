<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Candidato;

class CreateCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();

            $table->string("nome_completo");
            $table->date("data_de_nascimento");
            $table->integer("idade")->nullable(true);
            $table->string("cpf");
            $table->string("numero_cartao_sus");
            $table->enum('sexo', Candidato::SEXO_ENUM);
            $table->string("nome_da_mae");
            // $table->boolean("paciente_dificuldade_locomocao")->nullable(true);
            // $table->boolean("paciente_acamado")->nullable(true);
            // $table->boolean("paciente_agente_de_saude")->nullable(true);
            // $table->boolean("pessoa_idosa")->nullable(true);
            // $table->string("profissional_da_saude")->nullable(true);
            // $table->string("unidade_caso_agente_de_saude")->nullable(true); //Nome da unidade de o agente de saude trabalha
            $table->string("telefone");
            $table->string("whatsapp")->nullable(true);
            $table->string("email")->nullable(true);
            $table->unsignedBigInteger("cep")->nullable(true);
            $table->string("cidade");
            $table->string("bairro");
            $table->string("logradouro");
            $table->string("numero_residencia");
            $table->string("complemento_endereco")->nullable(true);
            $table->enum("aprovacao", Candidato::APROVACAO_ENUM)->default(Candidato::APROVACAO_ENUM[0]);
            $table->enum("dose", Candidato::DOSE_ENUM)->default(Candidato::DOSE_ENUM[0])->nullable(true);
            $table->datetime("chegada")->nullable(true);
            $table->datetime("saida")->nullable(true);
            $table->string("observacao")->nullable(true);

            $table->unsignedBigInteger('lote_id')->nullable(true);
            $table->unsignedBigInteger('posto_vacinacao_id')->nullable(true);
            $table->unsignedBigInteger('etapa_id');
            $table->string('etapa_resultado')->nullable(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatos');

    }
}
