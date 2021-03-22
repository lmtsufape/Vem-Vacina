<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_lote');
            $table->string('fabricante');
            $table->integer('numero_vacinas');
            $table->boolean('dose_unica');
            $table->integer("inicio_periodo");
            $table->integer("fim_periodo");
            $table->date("data_fabricacao")->nullable(true);
            $table->date("data_validade")->nullable(true);
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
        Schema::dropIfExists('lotes');
    }
}
