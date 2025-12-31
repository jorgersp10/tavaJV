<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto_det extends Model
{
    protected $table = 'presupuestos_det';

    use HasFactory;

    public function presupuesto(){
        return $this->belongsTo('App\Models\presupuesto','venta_id');
    }
}
