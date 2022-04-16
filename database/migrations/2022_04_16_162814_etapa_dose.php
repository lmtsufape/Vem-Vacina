<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EtapaDose extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapa_dose', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dose_id');
            $table->foreign('dose_id')->references('id')->on('doses');

            $table->unsignedBigInteger('etapa_id');
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
        Schema::dropIfExists('etapa_dose');
    }
}
