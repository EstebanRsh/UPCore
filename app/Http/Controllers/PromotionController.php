<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::all();
        return view('promotions.index', ['promotions' => $promotions]);
    }

    public function create()
    {
        return view('promotions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'duracion_meses' => 'required|integer|min:1',
            'tipo_descuento' => 'required|in:porcentaje,monto_fijo,meses_gratis',
            'valor_descuento' => 'required|numeric|min:0',
        ]);

        // Preparamos los datos para guardar, añadiendo 'activa' = true
        $dataToSave = array_merge($validated, ['activa' => true]);

        // Creamos la promoción con el array completo de datos
        Promotion::create($dataToSave);

        return redirect()->route('promotions.index')->with('success', '¡Promoción creada exitosamente!');
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
    public function edit(Promotion $promotion)
    {
        return view('promotions.edit', ['promotion' => $promotion]);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'duracion_meses' => 'required|integer|min:1',
            'tipo_descuento' => 'required|in:porcentaje,monto_fijo,meses_gratis',
            'valor_descuento' => 'required|numeric|min:0',
        ]);

        $promotion->update($validated);

        return redirect()->route('promotions.index')->with('success', '¡Promoción actualizada exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.index')->with('success', '¡Promoción eliminada exitosamente!');
    }
}
