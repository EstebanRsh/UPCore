<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Plan;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Client $client)
    {
        // Obtenemos solo los planes que están activos para ofrecer
        $plans = Plan::where('activo', true)->get();

        // Obtenemos las direcciones que pertenecen a este cliente específico
        $addresses = $client->serviceAddresses;

        return view('contracts.create', [
            'client' => $client,
            'plans' => $plans,
            'addresses' => $addresses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Client $client)
    {
        // 1. Validamos los datos del formulario.
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'service_address_id' => [
                'required',
                'exists:service_addresses,id',
                // Regla personalizada para asegurar que la dirección pertenezca al cliente.
                function ($attribute, $value, $fail) use ($client) {
                    if (!$client->serviceAddresses()->where('id', $value)->exists()) {
                        $fail('La dirección seleccionada no es válida para este cliente.');
                    }
                },
            ],
            'fecha_instalacion' => 'required|date',
            'estado' => 'required|string|in:Activo,Suspendido,Cancelado',
        ]);

        // 2. Usamos la relación para crear el contrato.
        // Eloquent asignará automáticamente el 'cliente_id'.
        $client->contracts()->create($validated);

        // 3. Redirigimos de vuelta a la página de detalles del cliente con un mensaje de éxito.
        return redirect()->route('clients.show', $client)->with('success', '¡Contrato creado exitosamente!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
