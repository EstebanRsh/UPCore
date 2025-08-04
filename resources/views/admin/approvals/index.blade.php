<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Aprobación de Usuarios Pendientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">¡Éxito!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">¡Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Nombre</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Email</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Fecha de Registro</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="py-3 px-4">{{ $user->name }}</td>
                                    <td class="py-3 px-4">{{ $user->email }}</td>
                                    <td class="py-3 px-4">{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('admin.approvals.approve', $user) }}" method="POST"
                                                onsubmit="return confirm('¿Estás seguro de que quieres aprobar a este usuario?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="bg-green-600 hover:bg-green-800 text-white font-bold py-1 px-3 rounded text-xs">
                                                    Aprobar
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.approvals.reject', $user) }}" method="POST"
                                                onsubmit="return confirm('¿Estás seguro de que quieres rechazar y eliminar a este usuario? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-800 text-white font-bold py-1 px-3 rounded text-xs">
                                                    Rechazar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3 px-4 text-center">No hay usuarios pendientes de
                                        aprobación.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
