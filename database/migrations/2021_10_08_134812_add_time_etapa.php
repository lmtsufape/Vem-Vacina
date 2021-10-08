<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeEtapa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etapas', function (Blueprint $table) {
            $table->integer('numero_dias')->default(0); 
            $table->date('intervalo_reforco')->nullable(true)->default(null); 
            $table->boolean('isDias')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etapas', function (Blueprint $table) {
            $table->dropColumn('numero_dias');
            $table->dropColumn('intervalo_reforco');
            $table->dropColumn('isDias');
        });
    }
}
