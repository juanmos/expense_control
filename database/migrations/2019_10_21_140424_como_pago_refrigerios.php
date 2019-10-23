<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ComoPagoRefrigerios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_refrigerios', function (Blueprint $table) {
            $table->enum('forma_pago', ['diario', 'semanal','mensual'])->default('diario')->after('costo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_refrigerios', function (Blueprint $table) {
            $table->dropColumn('forma_pago');
        });
    }
}
