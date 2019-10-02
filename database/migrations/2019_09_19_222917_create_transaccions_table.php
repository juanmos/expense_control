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
            $table->text('tipo_transaccion_id')->nullable();
            $table->morphs('transaccionable');
            $table->text('usuario_id');
            $table->text('fecha_hora')->nullable();
            $table->text('valor');
            $table->text('usuario_crea_id');
            $table->text('forma_pago_id');      
            $table->text('usuario_crea_ip');   
            $table->text('ubicacion')->nullable();   
            $table->text('telefono_uuid')->nullable();
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
