<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserApprovalController extends Controller
{
    /**
     * Muestra la lista de usuarios con el rol 'pendiente'.
     */
    public function index()
    {
        // Tu lógica original, que es la correcta.
        $pendingUsers = User::where('rol', 'pendiente')->get();

        return view('approvals.index', ['users' => $pendingUsers]);
    }

    /**
     * Aprueba un usuario, cambia su rol a 'cliente' y crea su perfil de cliente.
     */
    public function approve(User $user)
    {
        // Verificación de seguridad: si el usuario no está pendiente, no hacemos nada.
        if ($user->rol !== 'pendiente') {
            return redirect()->route('approvals.index')->with('error', 'El usuario no se puede aprobar o ya fue aprobado.');
        }

        try {
            // ¡Transacción! O ambas operaciones tienen éxito, o ninguna lo tiene.
            DB::transaction(function () use ($user) {
                // 1. Actualizamos el rol del usuario a 'cliente'
                $user->update(['rol' => 'cliente']);

                // 2. Creamos su perfil de cliente asociado
                Client::create([
                    'user_id' => $user->id,
                    'nombre' => $user->name,
                    'apellido' => '',
                    'email' => $user->email,
                    'dni_cuit' => null,
                    'telefono' => null,
                ]);
            });

            return redirect()->route('approvals.index')->with('success', 'Usuario ' . $user->name . ' aprobado y convertido en cliente.');
        } catch (\Exception $e) {
            return redirect()->route('approvals.index')->with('error', 'Error al aprobar el usuario: ' . $e->getMessage());
        }
    }
}
