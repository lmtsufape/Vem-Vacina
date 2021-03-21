<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapas', function (Blueprint $table) {
            $table->id();
            $table->integer('inicio_intervalo');
            $table->integer('fim_intervalo');
            $table->text('texto')->nullable(true);
            $table->boolean('atual');
            $table->boolean('dose_unica')->nullable(true);
            $table->bigInteger('total_pessoas_vacinadas_pri_dose')->nullable(true);
            $table->bigInteger('total_pessoas_vacinadas_seg_dose')->nullable(true);
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
        Schema::dropIfExists('etapas');
    }
}
