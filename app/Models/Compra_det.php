<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra_det extends Model
{
    protected $table = 'compras_det';

    use HasFactory;

    public function compra(){
        return $this->belongsTo('App\Models\compra','compra_id');
    }
}
