<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendedoresTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('vendedores')) {
            Schema::create('vendedores', function (Blueprint $table) {
                $table->id();
                $table->string('name', 200);
                $table->string('email', 100)->nullable();
                $table->string('num_documento', 100)->nullable();
                $table->string('direccion', 200)->nullable();
                $table->string('telefono', 100)->nullable();
                $table->integer('condicion')->nullable()->default(1);
                $table->date('dob')->nullable();
                $table->integer('idsucursal')->nullable();
                $table->unsignedBigInteger('user_id')->nullable()->unique();
                $table->string('remember_token', 100)->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('vendedores', function (Blueprint $table) {
                if (!Schema::hasColumn('vendedores', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable()->unique()->after('idsucursal');
                }
            });
        }
    }

    public function down()
    {
        Schema::table('vendedores', function (Blueprint $table) {
            if (Schema::hasColumn('vendedores', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
}
