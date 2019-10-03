<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarjetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarjetas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usuario_id');
            $table->integer('tipo_tarjeta_id');
            $table->decimal('cupo_mensual',10,3)->default(0);
            $table->boolean('perdida')->default(0);
            $table->dateTimeTz('fecha_solicitud');
            $table->dateTimeTz('fecha_emision')->nullable();
            $table->dateTimeTz('fecha_entrega')->nullable();
            $table->dateTimeTz('fecha_vencimiento');
            $table->dateTimeTz('fecha_perdida')->nullable();
            $table->string('codigo',500)->nullable();
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
        Schema::dropIfExists('tarjetas');
    }
}
