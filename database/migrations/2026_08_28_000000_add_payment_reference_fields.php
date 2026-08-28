<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentReferenceFields extends Migration
{
    public function up()
    {
        foreach (['pagos', 'pagos_compra', 'pagos_gasto'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'nro_comprobante_transferencia')) {
                    $table->string('nro_comprobante_transferencia')->nullable()->after('nro_cuenta');
                }
            });
        }

        foreach (['pagos_compra', 'pagos_gasto'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'nro_recibo_proveedor')) {
                    $table->string('nro_recibo_proveedor')->nullable()->after('nro_comprobante_transferencia');
                }
            });
        }
    }

    public function down()
    {
        foreach (['pagos_compra', 'pagos_gasto'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'nro_recibo_proveedor')) {
                    $table->dropColumn('nro_recibo_proveedor');
                }
            });
        }

        foreach (['pagos', 'pagos_compra', 'pagos_gasto'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'nro_comprobante_transferencia')) {
                    $table->dropColumn('nro_comprobante_transferencia');
                }
            });
        }
    }
}