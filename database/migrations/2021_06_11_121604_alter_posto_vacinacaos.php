<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPostoVacinacaos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posto_vacinacaos', function (Blueprint $table) {
            $table->unsignedInteger("inicio_atendimento_noite")->nullable(true);
            $table->unsignedInteger("intervalo_atendimento_noite")->nullable(true);
            $table->unsignedInteger("fim_atendimento_noite")->nullable(true);
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
            $table->dropColumn('inicio_atendimento_noite');
            $table->dropColumn('intervalo_atendimento_noite');
            $table->dropColumn('fim_atendimento_noite');
        });
    }
}
