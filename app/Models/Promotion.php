<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion_meses',
        'tipo_descuento',
        'valor_descuento',
        'activa',
    ];
}
