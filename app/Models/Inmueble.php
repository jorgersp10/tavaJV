<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    protected $table = 'inmuebles';

    use HasFactory;

    public function pagos(){
        return $this->hasMany('App\Models\Pago','inmueble_id');
    }

    public function loteamiento(){
        return $this->belongsTo('App\Models\Loteamiento','id');
    }

    public function cuota(){
        return $this->hasMany('App\Models\Cuota','inmueble_id');
    }

}
