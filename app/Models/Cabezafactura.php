<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabezafactura extends Model
{
    use HasFactory;
    protected $fillable = [
        'factura_id',
        'cab_fecha',
        'cliente_id',
        'cab_total'
    ];
}