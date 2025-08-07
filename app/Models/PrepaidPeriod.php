<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepaidPeriod extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'payment_id', 'fecha_inicio', 'fecha_fin', 'precio_congelado_mensual'];
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
