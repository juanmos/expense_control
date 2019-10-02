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
            $table->text('usuario_id');
            $table->text('tipo_tarjeta_id');
            $table->text('cupo_mensual');
            $table->text('perdida');
            $table->text('fecha_solicitud');
            $table->text('fecha_emision')->nullable();
            $table->text('fecha_entrega')->nullable();
            $table->text('fecha_vencimiento');
            $table->text('fecha_perdida')->nullable();
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
