<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota_det extends Model
{
    protected $table = 'cuotas_det';

    use HasFactory;

    public function cuota(){
        return $this->belongsTo('App\Models\Cuota','cuota_id');
    }
}
