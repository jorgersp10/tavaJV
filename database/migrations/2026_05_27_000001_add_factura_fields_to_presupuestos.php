<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFacturaFieldsToPresupuestos extends Migration
{
    public function up()
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            if (!Schema::hasColumn('presupuestos', 'contable')) {
                $table->integer('contable')->default(1)->after('user_id');
            }

            if (!Schema::hasColumn('presupuestos', 'empresa_id')) {
                $table->integer('empresa_id')->nullable()->default(1)->after('contable');
            }
        });

        Schema::table('presupuestos_det', function (Blueprint $table) {
            if (!Schema::hasColumn('presupuestos_det', 'servicio')) {
                $table->longText('servicio')->nullable()->after('producto_id');
            }

            if (!Schema::hasColumn('presupuestos_det', 'tipo_iva')) {
                $table->integer('tipo_iva')->nullable()->default(11)->after('precio');
            }
        });
    }

    public function down()
    {
        Schema::table('presupuestos_det', function (Blueprint $table) {
            if (Schema::hasColumn('presupuestos_det', 'tipo_iva')) {
                $table->dropColumn('tipo_iva');
            }

            if (Schema::hasColumn('presupuestos_det', 'servicio')) {
                $table->dropColumn('servicio');
            }
        });

        Schema::table('presupuestos', function (Blueprint $table) {
            if (Schema::hasColumn('presupuestos', 'empresa_id')) {
                $table->dropColumn('empresa_id');
            }

            if (Schema::hasColumn('presupuestos', 'contable')) {
                $table->dropColumn('contable');
            }
        });
    }
}
