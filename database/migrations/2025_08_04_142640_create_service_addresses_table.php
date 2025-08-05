<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Clave foránea
            $table->string('etiqueta'); // Ej: "Casa", "Comercio"
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('departamento')->nullable(); // Ej: "Piso 3, Dpto A" (opcional)
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_addresses');
    }
};
