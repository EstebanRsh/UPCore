<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientNote extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'user_id', 'note'];

    /**
     * Cada nota pertenece a un cliente.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Cada nota fue escrita por un usuario (manager).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}