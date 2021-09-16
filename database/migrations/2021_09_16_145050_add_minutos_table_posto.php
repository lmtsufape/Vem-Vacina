<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinutosTablePosto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posto_vacinacaos', function (Blueprint $table) {
            $table->unsignedInteger("minutos_inicio_atendimento_manha")->nullable(true);
            $table->unsignedInteger("minutos_fim_atendimento_manha")->nullable(true);

            $table->unsignedInteger("minutos_inicio_atendimento_tarde")->nullable(true);
            $table->unsignedInteger("minutos_fim_atendimento_tarde")->nullable(true);

            $table->unsignedInteger("minutos_inicio_atendimento_noite")->nullable(true);
            $table->unsignedInteger("minutos_fim_atendimento_noite")->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posto_vacinacaos', function (Blueprint $table) {
            //
        });
    }
}
