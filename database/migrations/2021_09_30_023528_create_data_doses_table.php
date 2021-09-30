<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_doses', function (Blueprint $table) {
            $table->id();

            $table->datetime("data_um")->nullable(true);
            $table->datetime("data_dois")->nullable(true);

            $table->unsignedBigInteger('candidato_id')->nullable(true);
            $table->foreign('candidato_id')->references('id')->on('candidatos');

            $table->softDeletes();
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
        Schema::dropIfExists('data_doses');
    }
}
