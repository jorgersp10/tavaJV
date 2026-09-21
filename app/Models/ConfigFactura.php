<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigFactura extends Model
{
    use HasFactory;

    protected $table = 'config_facturas';

    protected $fillable = ['cabecera', 'cabecera2', 'cabecera3'];

    /**
     * Devuelve el único registro de configuración, creándolo con valores por defecto si no existe.
     */
    public static function actual()
    {
        return static::firstOrCreate([], [
            'cabecera' => 113,
            'cabecera2' => 223,
            'cabecera3' => 340,
        ]);
    }
}
