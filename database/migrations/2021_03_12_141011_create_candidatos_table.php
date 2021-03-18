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
            $table->string("cpf");
            $table->string("numero_cartao_sus");
            $table->enum('sexo', Candidato::SEXO_ENUM);
            $table->string("nome_da_mae");
            $table->string("foto_frente_rg");
            $table->string("foto_tras_rg");
            $table->boolean("paciente_acamado");
            $table->boolean("paciente_agente_de_saude");
            $table->string("unidade_caso_agente_de_saude")->nullable(true); //Nome da unidade de o agente de saude trabalha
            $table->string("telefone");
            $table->string("whatsapp")->nullable(true);
            $table->string("email")->nullable(true);
            $table->unsignedBigInteger("cep");
            $table->string("cidade");
            $table->string("bairro");
            $table->string("logradouro");
            $table->string("numero_residencia");
            $table->string("complemento_endereco")->nullable(true);
            $table->enum("aprovacao", Candidato::APROVACAO_ENUM)->default(Candidato::APROVACAO_ENUM[0]);
            $table->datetime("chegada");
            $table->datetime("saida");
            $table->timestamps();
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
