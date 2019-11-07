<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuRefrigeriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_refrigerios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('institucion_id');
            $table->integer('tipo_refrigerio_id');
            $table->date('fecha');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('foto')->nullable();
            $table->text('tabla_nutricional')->nullable();
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
        Schema::dropIfExists('menu_refrigerios');
    }
}
