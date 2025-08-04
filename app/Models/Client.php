<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // 
        'nombre', // 
        'apellido', // 
        'dni_cuit', // 
        'direccion_servicio', // 
        'telefono', // 
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
    public function contracts()
    {
        // El segundo argumento es la foreign key en la tabla 'contracts'
        return $this->hasMany(Contract::class, 'cliente_id');
    }
}
