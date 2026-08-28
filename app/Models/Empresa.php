<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'empresas';

    protected $fillable=[
        'empresas'];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'empresa_user', 'empresa_id', 'user_id');
    }

}
