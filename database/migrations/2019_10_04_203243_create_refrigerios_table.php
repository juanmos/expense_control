<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefrigeriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refrigerios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tipo_refrigerio_id');
            $table->integer('institucion_id');
            $table->morphs('userable');
            $table->decimal('costo',10,2)->default(0);
            $table->boolean('activo')->default(1);
            $table->dateTimeTz('fecha_inicio');
            $table->dateTimeTz('fecha_fin')->nullable();
            $table->json('dias');
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
        Schema::dropIfExists('refrigerios');
    }
}
