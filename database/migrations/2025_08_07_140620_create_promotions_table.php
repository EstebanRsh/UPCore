<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: "Promo Verano 3 Meses"
            $table->text('descripcion'); // Ej: "Paga 3 meses y obtén un 10% de descuento"
            $table->integer('duracion_meses'); // Ej: 3
            $table->enum('tipo_descuento', ['porcentaje', 'monto_fijo', 'meses_gratis']);
            $table->decimal('valor_descuento', 8, 2); // Ej: 10.00 (para 10%) o 50.00 (para $50) o 1 (para 1 mes gratis)
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
