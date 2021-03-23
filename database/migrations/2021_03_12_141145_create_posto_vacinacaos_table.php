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
<<<<<<< HEAD
            $table->bigInteger('vacinas_disponiveis')->default(0);
            // $table->boolean("para_idoso");
            // $table->boolean("para_profissional_da_saude");
            $table->boolean('padrao_no_formulario');
=======
            $table->boolean("para_idoso");
            $table->boolean("para_profissional_da_saude");
>>>>>>> ca1e4c87ea523473fbdf2f6bf7fdab1b303d4291
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
