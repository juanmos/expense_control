<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaccions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('institucion_id')->default(0);
            $table->integer('tipo_transaccion_id')->default(1);
            $table->integer('usuario_id');
            $table->dateTime('fecha_hora')->nullable();
            $table->decimal('valor',12,3)->default(0);
            $table->integer('usuario_crea_id');
            $table->integer('forma_pago_id')->default(1);            
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
        Schema::dropIfExists('transaccions');
    }
}
