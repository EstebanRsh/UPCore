<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;



class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', // 
        'nombre', // 
        'apellido', // 
        'dni_cuit', // 
        'telefono', // 
        'email',
    ];

    /**
     * Get the user that owns the client profile.
     * Relación Inversa 1 a 1 con User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contracts for the client.
     * Relación 1 a N con Contrato 
     */
    public function serviceAddresses()
    {
        return $this->hasMany(ServiceAddress::class, 'client_id');
    }
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'cliente_id');
    }
    public function notes()
    {
        return $this->hasMany(ClientNote::class)->latest();
    }
    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Contract::class, 'cliente_id', 'contrato_id');
    }
}
