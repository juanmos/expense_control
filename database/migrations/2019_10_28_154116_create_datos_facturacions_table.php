<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosFacturacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_facturacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usuario_id');
            $table->string('nombre');
            $table->string('ruc');
            $table->string('email');
            $table->string('telefono')->nullable();            
            $table->string('direccion')->nullable();
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
        Schema::dropIfExists('datos_facturacions');
    }
}
