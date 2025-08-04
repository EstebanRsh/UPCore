<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planes = Plan::all(); // Obtiene todos los planes de la BD
        return view('planes.index', ['planes' => $planes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('planes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
        $validated = $request->validate([
            'nombre_plan' => 'required|string|max:255',
            'velocidad_mbps' => 'required|integer|min:1',
            'precio_mensual' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        // 2. Crear el Plan con los datos validados
        Plan::create($validated);

        // 3. Redirigir al usuario de vuelta a la lista de planes con un mensaje de éxito
        return redirect()->route('planes.index')->with('success', '¡Plan creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plane)
    {
        return view('planes.edit', ['plan' => $plane]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plane)
    {
        // 1. Validar los datos
        $validated = $request->validate([
            'nombre_plan' => 'required|string|max:255',
            'velocidad_mbps' => 'required|integer|min:1',
            'precio_mensual' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        // 2. Actualizar el plan con los datos validados
        $plane->update($validated);

        // 3. Redirigir con mensaje de éxito
        return redirect()->route('planes.index')->with('success', '¡Plan actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plane)
    {
        // 1. Eliminar el plan de la base de datos
        $plane->delete();

        // 2. Redirigir con un mensaje de éxito
        return redirect()->route('planes.index')->with('success', '¡Plan eliminado exitosamente!');
    }
}
