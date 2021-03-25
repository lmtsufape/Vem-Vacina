<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoteEtapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lote_etapas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lote_id')->nullable(true);
            $table->unsignedBigInteger('etapa_id')->nullable(true);

            $table->foreign('lote_id')->references('id')->on('lotes');
            $table->foreign('etapa_id')->references('id')->on('etapas');

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
        Schema::dropIfExists('lote_etapas');
    }
}
