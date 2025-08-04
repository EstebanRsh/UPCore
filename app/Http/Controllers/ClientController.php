<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Y este para la validación avanzada

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenemos todos los clientes y cargamos la relación 'user' para evitar N+1 problems.
        $clients = Client::with('user')->get();

        return view('clients.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        // Cargamos las relaciones para tener acceso a los datos del usuario y sus direcciones
        $client->load('user', 'serviceAddresses', 'contracts.plan');

        return view('clients.show', ['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'dni_cuit' => [
                'required',
                'string',
                'max:20',
                Rule::unique('clients')->ignore($client->id), // Ignora el DNI/CUIT de este cliente al validar
            ],
        ]);

        $client->update($validated);

        // Redirigimos de vuelta a la página de detalles para ver los cambios
        return redirect()->route('clients.show', $client)->with('success', '¡Información del cliente actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
