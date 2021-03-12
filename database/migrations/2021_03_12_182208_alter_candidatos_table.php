<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidatos', function (Blueprint $table) {
            
            $table->unsignedBigInteger('lote_id');
            $table->unsignedBigInteger('posto_vacinacao_ìd');

            $table->foreign('lote_id')->references('id')->on('lotes');
            $table->foreign('posto_vacinacao_ìd')->references('id')->on('posto_vacinacaos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidatos', function (Blueprint $table) {
            //
        });
    }
}
