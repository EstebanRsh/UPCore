<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'plan_id',
        'service_address_id',
        'fecha_instalacion',
        'estado',
    ];

    /**
     * Get the client that owns the contract.
     * Relación Inversa N a 1 con Cliente
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    /**
     * Get the plan associated with the contract.
     * Relación Inversa N a 1 con Plan
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function serviceAddress()
    {
        return $this->belongsTo(ServiceAddress::class);
    }

    /**
     * Get the invoices for the contract.
     * Relación 1 a N con Factura
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'contrato_id');
    }
}
