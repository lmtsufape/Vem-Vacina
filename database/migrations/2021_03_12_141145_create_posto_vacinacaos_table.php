<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostoVacinacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posto_vacinacaos', function (Blueprint $table) {
            $table->id();
            $table->string("nome");
            $table->string("endereco");
            $table->bigInteger('vacinas_disponiveis')->default(0);
            // $table->boolean("para_idoso");
            // $table->boolean("para_profissional_da_saude");
            $table->boolean('padrao_no_formulario');
            $table->timestamps();
            $table->softDeletes();


            $table->unsignedInteger("inicio_atendimento_manha")->nullable(true);
            $table->unsignedInteger("intervalo_atendimento_manha")->nullable(true);
            $table->unsignedInteger("fim_atendimento_manha")->nullable(true);

            $table->unsignedInteger("inicio_atendimento_tarde")->nullable(true);
            $table->unsignedInteger("intervalo_atendimento_tarde")->nullable(true);
            $table->unsignedInteger("fim_atendimento_tarde")->nullable(true);


            // Fazer da forma mais simples e obvia, sem lógicas complicadas, evitando
            // quaisquer dores de cabeça

            $table->boolean("funciona_domingo");
            $table->boolean("funciona_segunda");
            $table->boolean("funciona_terca");
            $table->boolean("funciona_quarta");
            $table->boolean("funciona_quinta");
            $table->boolean("funciona_sexta");
            $table->boolean("funciona_sabado");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posto_vacinacaos');
    }
}
