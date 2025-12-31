<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $table = 'cuotas';

    use HasFactory;

    public function cuotas_det(){
        return $this->hasMany('App\Models\Cuota_det','cuota_id');
    }

    public function inmuebles(){
        return $this->belongsTo('App\Models\Inmueble','inmueble_id');
    }

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente','cliente_id');
    }
}
