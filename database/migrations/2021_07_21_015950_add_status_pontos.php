<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPontos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posto_vacinacaos', function (Blueprint $table) {
            $table->string('status') // Nome da coluna
                    ->default('ativo')// Preenchimento não obrigatório
                    ->after('padrao_no_formulario');
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
            $table->dropColumn('status');
        });
    }
}
