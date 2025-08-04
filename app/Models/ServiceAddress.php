<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'etiqueta',
        'direccion',
        'ciudad',
        'departamento',
        'notas',
    ];

    /**
     * Get the client that owns the service address.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
