<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contrato_id', // 
        'fecha_emision', // 
        'fecha_vencimiento', // 
        'monto', // 
        'estado', // 
    ];

    /**
     * Get the contract that the invoice belongs to.
     * Relación Inversa N a 1 con Contrato
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contrato_id');
    }

    /**
     * Get the payments for the invoice.
     * Relación 1 a N con Pago 
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'factura_id');
    }
}
