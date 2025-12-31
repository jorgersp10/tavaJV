<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    use HasFactory;
    protected $guarded = [];

    public function inmueble(){
        return $this->belongsTo('App\Models\Inmueble','inmueble_id');
    }

}
