<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;



class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'nombre', 'apellido', 'dni_cuit', 'telefono', 'email'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'cliente_id');
    }

    public function serviceAddresses()
    {
        return $this->hasMany(ServiceAddress::class);
    }

    public function notes()
    {
        return $this->hasMany(ClientNote::class)->latest();
    }

    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Contract::class, 'cliente_id', 'contrato_id');
    }
    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            Invoice::class,
            'contrato_id', // Clave foránea en la tabla 'invoices' (que conecta con contracts)
            'factura_id',   // Clave foránea en la tabla 'payments' (que conecta con invoices)
            'id',           // Clave local en la tabla 'clients'
            'id'            // Clave local en la tabla 'invoices'
        )->join('contracts', 'invoices.contrato_id', '=', 'contracts.id')
            ->where('contracts.cliente_id', $this->id);
    }
}
