<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FacturacionCliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->integer('cliente_id')->default(0)->after('institucion_id');
            $table->string('establecimiento',15)->nullable()->after('factura_no');
            $table->string('puntoEmision',15)->nullable()->after('establecimiento');
            $table->string('secuencia',25)->nullable()->after('puntoEmision');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('cliente_id');
            $table->dropColumn('establecimiento');
            $table->dropColumn('puntoEmision');
            $table->dropColumn('secuencia');
        });
    }
}
