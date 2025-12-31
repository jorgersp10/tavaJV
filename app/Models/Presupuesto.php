<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    
    use HasFactory;

    protected $table = 'presupuestos';

    use HasFactory;

    public function presupuestos_det(){
        return $this->hasMany('App\Models\Presupuestos_det','venta_id');
    }

    public function productos(){
        return $this->belongsTo('App\Models\Producto','producto_id');
    }

    public function clientes(){
        return $this->belongsTo('App\Models\Cliente','cliente_id');
    }
}
