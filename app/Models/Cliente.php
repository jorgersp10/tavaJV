<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'nombres12',
    ];

    public function cuotas(){
        return $this->hasMany('App\Models\Cuota','cliente_id');
    }
}
