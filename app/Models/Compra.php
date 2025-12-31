<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

    use HasFactory;

    public function compras_det(){
        return $this->hasMany('App\Models\Compra_det','compra_id');
    }

    public function productos(){
        return $this->belongsTo('App\Models\Producto','producto_id');
    }

    public function proveedores(){
        return $this->belongsTo('App\Models\Proveedor','id_proveedor');
    }
}
