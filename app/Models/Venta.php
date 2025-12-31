<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    
    use HasFactory;

    protected $table = 'ventas';

    // use HasFactory;

    // public function ventas_det(){
    //     return $this->hasMany('App\Models\Venta_det','venta_id');
    // }

    // public function productos(){
    //     return $this->belongsTo('App\Models\Producto','producto_id');
    // }

    // public function clientes(){
    //     return $this->belongsTo('App\Models\Cliente','cliente_id');
    // }
}
