<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientNoteController extends Controller
{
    /**
     * Guarda una nueva nota para un cliente.
     */
    public function store(Request $request, Client $client)
    {
        $request->validate(['note' => 'required|string|max:5000']);
        $client->notes()->create([
            'note' => $request->note,
            'user_id' => Auth::id(),
        ]);
        return back()->with('success', 'Nota añadida exitosamente.');
    }
    /**
     * Actualiza una nota existente.
     */
    public function update(Request $request, ClientNote $note)
    {
        // Opcional: Podrías añadir una política de seguridad para asegurar que solo el autor o un admin pueda editar.
        $request->validate(['note' => 'required|string|max:5000']);
        $note->update(['note' => $request->note]);
        return back()->with('success', 'Nota actualizada exitosamente.');
    }

    /**
     * Elimina una nota.
     */
    public function destroy(ClientNote $note)
    {
        // Opcional: Política de seguridad aquí también.
        $note->delete();
        return back()->with('success', 'Nota eliminada exitosamente.');
    }
}