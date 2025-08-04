<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_plan', // 
        'velocidad_mbps', // 
        'precio_mensual', // 
        'descripcion', // 
        'activo', // 
    ];

    /**
     * Get the contracts associated with the plan.
     * Relación 1 a N con Contrato 
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
