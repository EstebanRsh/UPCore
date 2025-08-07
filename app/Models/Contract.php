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

    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function serviceAddress()
    {
        return $this->belongsTo(ServiceAddress::class);
    }

    // --- AÑADE ESTA NUEVA FUNCIÓN ---
    /**
     * Un Contrato genera muchas Facturas.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'contrato_id');
    }

    /**
     * Un Contrato puede tener muchos períodos prepagados.
     */
    public function prepaidPeriods()
    {
        return $this->hasMany(PrepaidPeriod::class);
    }
}
