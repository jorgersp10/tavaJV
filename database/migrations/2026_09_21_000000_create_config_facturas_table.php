<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cabecera')->default(113);
            $table->unsignedInteger('cabecera2')->default(223);
            $table->unsignedInteger('cabecera3')->default(340);
            $table->timestamps();
        });

        // Registro único con los valores por defecto usados actualmente en la vista.
        DB::table('config_facturas')->insert([
            'cabecera' => 113,
            'cabecera2' => 223,
            'cabecera3' => 340,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_facturas');
    }
};
