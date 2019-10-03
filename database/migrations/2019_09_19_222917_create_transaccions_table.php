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
            $table->integer('tipo_transaccion_id')->default(1);
            $table->morphs('transaccionable');
            $table->integer('usuario_id');
            $table->integer('tarjeta_id');
            $table->dateTimeTz('fecha_hora')->nullable();
            $table->decimal('valor',12,3)->default(0);
            $table->integer('usuario_crea_id');
            $table->integer('forma_pago_id')->default(1);  
            $table->ipAddress('usuario_crea_ip');   
            $table->point('ubicacion')->nullable();   
            $table->uuid('telefono_uuid')->nullable();
            $table->macAddress('dispositivo')->nullable();
            $table->timestampsTz();
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
