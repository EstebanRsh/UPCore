<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientNoteController extends Controller
{
    /**
     * Guarda una nueva nota para un cliente.
     */
    public function store(Request $request, Client $client)
    {
        $request->validate([
            'note' => 'required|string|max:5000',
        ]);

        $client->notes()->create([
            'note' => $request->note,
            'user_id' => Auth::id(), // Asigna la nota al manager que ha iniciado sesión
        ]);

        return redirect()->route('clients.show', $client)->with('success', 'Nota añadida exitosamente.');
    }
}