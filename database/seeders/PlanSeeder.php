<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'nombre_plan' => 'Fibra Básica',
            'velocidad_mbps' => 100,
            'precio_mensual' => 30.00,
            'descripcion' => 'Ideal para navegación y streaming.',
        ]);
        Plan::create([
            'nombre_plan' => 'Fibra Plus',
            'velocidad_mbps' => 300,
            'precio_mensual' => 45.00,
            'descripcion' => 'Perfecto para teletrabajo y gaming.',
        ]);
        Plan::create([
            'nombre_plan' => 'Fibra Pro',
            'velocidad_mbps' => 600,
            'precio_mensual' => 60.00,
            'descripcion' => 'Máxima velocidad para usuarios exigentes.',
        ]);
    }
}
