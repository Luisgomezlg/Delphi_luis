<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculoSalarial extends Model
{
    use HasFactory;
    protected $fillable = [
        'cal_nombreempleado',
        'cal_horas',
        'cal_salario'
    ];
}