<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InstitucionTipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('institucions', function (Blueprint $table) {
            $table->integer('tipo_institucion_id')->default(1)->after('nombre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institucions', function (Blueprint $table) {
            $table->dropColumn('tipo_institucion_id');
        });
    }
}
