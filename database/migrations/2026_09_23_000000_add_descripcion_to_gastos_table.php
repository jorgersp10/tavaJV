<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescripcionToGastosTable extends Migration
{
    public function up()
    {
        Schema::table('gastos', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->after('fact_compra');
        });
    }

    public function down()
    {
        Schema::table('gastos', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });
    }
}