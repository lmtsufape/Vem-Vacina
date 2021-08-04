<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostoVacinacaoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posto_vacinacao_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('posto_vacinacao_id')->nullable(true);
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
        Schema::dropIfExists('posto_vacinacao_user');
    }
}
