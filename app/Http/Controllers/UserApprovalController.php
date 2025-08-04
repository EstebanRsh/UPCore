<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserApprovalController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('rol', 'pendiente')->get();
        return view('admin.approvals.index', ['users' => $pendingUsers]);
    }
    public function approve(User $user)
    {
        // Usamos una transacción para asegurar la integridad de los datos.
        // O ambas operaciones tienen éxito, o ninguna lo tiene.
        DB::transaction(function () use ($user) {

            // 1. Actualizamos el rol del usuario a 'cliente'
            $user->update(['rol' => 'cliente']);

            // 2. Creamos su perfil de cliente asociado
            Client::create([
                'user_id' => $user->id,
                'nombre' => $user->name,
                'apellido' => '',
                'dni_cuit' => '',
                'telefono' => '',
            ]);
        });

        return redirect()->route('admin.approvals.index')->with('success', '¡Usuario aprobado exitosamente!');
    }
    public function reject(User $user)
    {
        // Por seguridad, nos aseguramos de que solo se puedan eliminar usuarios pendientes.
        if ($user->rol === 'pendiente') {
            $user->delete();
            return redirect()->route('admin.approvals.index')->with('success', '¡Usuario rechazado y eliminado exitosamente!');
        }

        // Si por alguna razón se intenta eliminar a un usuario que no está pendiente,
        // redirigimos con un error.
        return redirect()->route('admin.approvals.index')->with('error', 'Solo se pueden eliminar usuarios pendientes.');
    }
}
