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
            $table->date('intervalo_reforco')->nullable(true)->default(null); 
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
            $table->dropColumn('intervalo_reforco');
        });
    }
}
