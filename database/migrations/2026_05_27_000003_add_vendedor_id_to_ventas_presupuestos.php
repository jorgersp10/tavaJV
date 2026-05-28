<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendedorIdToVentasPresupuestos extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            if (!Schema::hasColumn('ventas', 'vendedor_id')) {
                $table->unsignedBigInteger('vendedor_id')->nullable()->after('empresa_id');
            }
        });

        Schema::table('presupuestos', function (Blueprint $table) {
            if (!Schema::hasColumn('presupuestos', 'vendedor_id')) {
                $table->unsignedBigInteger('vendedor_id')->nullable()->after('empresa_id');
            }
        });
    }

    public function down()
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            if (Schema::hasColumn('presupuestos', 'vendedor_id')) {
                $table->dropColumn('vendedor_id');
            }
        });

        Schema::table('ventas', function (Blueprint $table) {
            if (Schema::hasColumn('ventas', 'vendedor_id')) {
                $table->dropColumn('vendedor_id');
            }
        });
    }
}
