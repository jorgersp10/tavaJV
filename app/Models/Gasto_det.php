<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto_det extends Model
{
    protected $table = 'gastos_det';

    use HasFactory;

    public function compra(){
        return $this->belongsTo('App\Models\gasto','gasto_id');
    }
}
