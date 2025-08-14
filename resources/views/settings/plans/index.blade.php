<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Configuración → Planes y tarifas
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow sm:rounded p-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <form method="GET" class="flex gap-2">
                    <input type="text" name="q" value="{{ $q ?? '' }}"
                        placeholder="Buscar por nombre/desc..." class="border rounded p-2 w-64">
                    <select name="estado" class="border rounded p-2">
                        <option value="">Todos</option>
                        <option value="Activo" {{ ($estado ?? '') === 'Activo' ? 'selected' : '' }}>Activos</option>
                        <option value="Inactivo" {{ ($estado ?? '') === 'Inactivo' ? 'selected' : '' }}>Inactivos
                        </option>
                    </select>
                    <button class="px-3 py-2 bg-gray-800 text-white rounded">Filtrar</button>
                </form>

                <a href="{{ route('settings.planes.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">
                    Nuevo plan
                </a>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-600">
                            <th class="py-2">Nombre</th>
                            <th>Velocidad</th>
                            <th>Precio mensual</th>
                            <th>Estado</th>
                            <th>Contratos</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($planes as $p)
                            <tr class="border-t">
                                <td class="py-2 font-medium">{{ $p->nombre_plan }}</td>
                                <td>{{ $p->velocidad_mbps }} Mbps</td>
                                <td>${{ number_format($p->precio_mensual, 2) }}</td>
                                <td>
                                    @if ($p->activo)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-emerald-100 text-emerald-800">Activo</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-gray-200 text-gray-700">Inactivo</span>
                                    @endif
                                </td>
                                <td>{{ $p->contracts_count }}</td>
                                <td class="text-right space-x-2">
                                    <a href="{{ route('settings.planes.edit', $p) }}"
                                        class="text-indigo-600 hover:underline">Editar precio</a>

                                    <form action="{{ route('settings.planes.toggle', $p) }}" method="POST"
                                        class="inline">
                                        @csrf @method('PATCH')
                                        <button class="text-gray-700 hover:underline" type="submit">
                                            {{ (is_bool($p->activo) ? $p->activo : $p->activo === 'Activo') ? 'Inactivar' : 'Activar' }}
                                        </button>
                                    </form>

                                    @if ($p->contracts_count == 0)
                                        <form action="{{ route('settings.planes.destroy', $p) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('¿Eliminar este plan? Esta acción no se puede deshacer.');">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline"
                                                type="submit">Eliminar</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 ml-2"
                                            title="Tiene contratos, no se puede eliminar">Eliminar</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-gray-500">No hay planes cargados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $planes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
