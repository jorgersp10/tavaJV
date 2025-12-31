<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta_det extends Model
{
    protected $table = 'ventas_det';

    use HasFactory;

    // public function venta(){
    //     return $this->belongsTo('App\Models\venta','venta_id');
    // }
}
