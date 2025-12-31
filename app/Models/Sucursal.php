<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'sucursales';

    protected $fillable=[
        'sucursal'];

    public function usuarios(){
        return $this->hasMany('App\Models\Usuarios','idsucursal');
    }



}
