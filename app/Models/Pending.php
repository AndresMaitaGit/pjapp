<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product',
        'total_sin_impuesto',
        'total_de_impuesto',
        'total_a_pagar',
    ];
}
