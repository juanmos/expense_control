<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SoftdeletesTablas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('categoria_productos', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('categoria_servicios', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('clientes', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('datos_facturacions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('facturas', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('factura_detalles', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('institucions', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('categoria_productos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('categoria_servicios', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('datos_facturacions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('factura_detalles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('institucions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
