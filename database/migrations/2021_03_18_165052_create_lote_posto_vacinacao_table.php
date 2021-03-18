<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotePostoVacinacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lote_posto_vacinacao', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('qtdVacina')->default(0);

            $table->unsignedBigInteger('lote_id')->nullable(true);
            $table->unsignedBigInteger('posto_vacinacao_id')->nullable(true);

            $table->foreign('lote_id')->references('id')->on('lotes');
            $table->foreign('posto_vacinacao_id')->references('id')->on('posto_vacinacaos');

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
        Schema::dropIfExists('lote_posto_vacinacao');
    }
}
