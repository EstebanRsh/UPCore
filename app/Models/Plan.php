<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_plan',
        'velocidad_mbps',
        'precio_mensual',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'bool',
        'precio_mensual' => 'decimal:2',
    ];

    public function contracts()
    {
        // FK por convención: plan_id en contracts
        return $this->hasMany(Contract::class, 'plan_id');
    }

    /** Scope para listar solo activos */
    public function scopeActivo($q)
    {
        return $q->where('activo', true);
    }
}
