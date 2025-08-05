<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ServiceAddress;
use Illuminate\Http\Request;

class ServiceAddressController extends Controller
{
    /**
     * Muestra el formulario para crear una nueva dirección para un cliente específico.
     */
    public function create(Client $client)
    {
        return view('clients.addresses.create', ['client' => $client]);
    }

    /**
     * Guarda la nueva dirección en la base de datos.
     */
    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'etiqueta' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ]);

        $client->serviceAddresses()->create($validated);

        return redirect()->route('clients.show', $client)->with('success', '¡Dirección añadida exitosamente!');
    }

    /**
     * Muestra el formulario para editar una dirección existente.
     */
    public function edit(Client $client, ServiceAddress $address)
    {
        return view('clients.addresses.edit', ['client' => $client, 'address' => $address]);
    }

    /**
     * Actualiza una dirección existente en la base de datos.
     */
    public function update(Request $request, Client $client, ServiceAddress $address)
    {
        $validated = $request->validate([
            'etiqueta' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ]);

        $address->update($validated);

        return redirect()->route('clients.show', $client)->with('success', '¡Dirección actualizada exitosamente!');
    }

    /**
     * Elimina una dirección de servicio.
     */
    public function destroy(Client $client, ServiceAddress $address)
    {
        $address->delete();

        return redirect()->route('clients.show', $client)->with('success', '¡Dirección eliminada exitosamente!');
    }
}
