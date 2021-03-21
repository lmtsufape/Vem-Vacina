<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostoVacinacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posto_vacinacaos', function (Blueprint $table) {
            $table->id();
            $table->string("nome");
            $table->string("endereco");
            $table->boolean("para_idoso");
            $table->boolean("para_profissional_da_saude");
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
        Schema::dropIfExists('posto_vacinacaos');
    }
}
