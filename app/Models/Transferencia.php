<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'transferencias';

    protected $fillable=[
        'transferencias'];

}
