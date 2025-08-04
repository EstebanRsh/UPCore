<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id', // 
        'fecha_pago', // 
        'monto_pagado', // 
        'metodo_pago', // 
        'notas', // 
    ];

    /**
     * Get the invoice that the payment belongs to.
     * Relación Inversa N a 1 con Factura
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'factura_id');
    }
}
