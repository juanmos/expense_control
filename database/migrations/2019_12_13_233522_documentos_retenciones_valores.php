<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DocumentosRetencionesValores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documento_fisicos', function (Blueprint $table) {
            $table->decimal('ret_renta',10,2)->default(0)->after('total');
            $table->decimal('ret_iva',10,2)->default(0)->after('ret_renta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documento_fisicos', function (Blueprint $table) {
            $table->dropColumn('ret_renta');
            $table->dropColumn('ret_iva');
        });
    }
}
