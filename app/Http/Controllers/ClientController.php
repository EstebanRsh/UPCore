<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with('user')->latest()->get();
        return view('clients.manager.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
                // Simplemente muestra la vista del formulario de creación.
        return view('clients.manager.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
    {
        // 1. Validamos todos los datos de una vez.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'dni_cuit' => ['required', 'string', 'max:255', 'unique:'.Client::class],
            'telefono' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            // 2. Usamos una transacción para garantizar que ambas creaciones tengan éxito.
            DB::transaction(function () use ($validated) {
                // 3. Creamos el Usuario con el rol 'cliente'.
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'rol' => 'cliente', // ¡Asignamos el rol directamente!
                ]);

                // 4. Creamos el Cliente y lo asociamos con el Usuario.
                $user->client()->create([
                    'nombre' => $validated['name'],
                    'apellido' => $validated['apellido'],
                    'email' => $validated['email'],
                    'dni_cuit' => $validated['dni_cuit'],
                    'telefono' => $validated['telefono'],
                ]);
            });

        } catch (\Exception $e) {
            // Si algo falla, volvemos con un error.
            return redirect()->back()
                ->with('error', 'Hubo un error al crear el cliente: ' . $e->getMessage())
                ->withInput();
        }

        // 5. Si todo sale bien, redirigimos a la lista de clientes.
        return redirect()->route('clients.index')
            ->with('success', '¡Cliente creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        // Cargamos las relaciones para tener acceso a los datos del usuario y sus direcciones
        $client->load('user', 'serviceAddresses', 'contracts.plan');

        return view('clients.manager.show', ['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.manager.edit', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'dni_cuit' => [
                'nullable',
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
    public function destroy(Client $client)
    {
        // Usamos una transacción para asegurar que ambas operaciones se completen
        DB::transaction(function () use ($client) {
            // Obtenemos el usuario asociado al cliente
            $user = $client->user;

            // Realizamos la baja lógica del cliente
            $client->delete();

            // Y también la baja lógica del usuario para que no pueda iniciar sesión
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('clients.index')->with('success', '¡Cliente dado de baja exitosamente!');
    }
}
