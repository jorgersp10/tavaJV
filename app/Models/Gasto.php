<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    protected $table = 'gastos';

    use HasFactory;

    public function compras_det(){
        return $this->hasMany('App\Models\Gasto_det','gasto_id');
    }

    public function productos(){
        return $this->belongsTo('App\Models\Producto','producto_id');
    }

    public function proveedores(){
        return $this->belongsTo('App\Models\Proveedor','id_proveedor');
    }
}
