<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4 sm:mb-0">
                Listado de Clientes
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="GET" action="{{ route('clients.index') }}">
                        <div class="bg-gray-50 p-4 rounded-lg mb-6 border">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label for="search" class="text-sm font-medium text-gray-700">Buscar</label>
                                    <input type="text" name="search" id="search" placeholder="Nombre, Apellido, DNI..."
                                        class="mt-1 w-full rounded-md shadow-sm border-gray-300"
                                        value="{{ $filters['search'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="city" class="text-sm font-medium text-gray-700">Ciudad</label>
                                    <input type="text" name="city" id="city" placeholder="Ej: Paraná"
                                        class="mt-1 w-full rounded-md shadow-sm border-gray-300"
                                        value="{{ $filters['city'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="sort_by" class="text-sm font-medium text-gray-700">Ordenar por</label>
                                    <select name="sort_by" id="sort_by" class="mt-1 w-full rounded-md shadow-sm border-gray-300">
                                        <option value="created_at" @selected(($filters['sort_by'] ?? '') === 'created_at')>Fecha de Registro</option>
                                        <option value="nombre" @selected(($filters['sort_by'] ?? '') === 'nombre')>Nombre</option>
                                        <option value="apellido" @selected(($filters['sort_by'] ?? '') === 'apellido')>Apellido</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="sort_direction" class="text-sm font-medium text-gray-700">Dirección</label>
                                    <select name="sort_direction" id="sort_direction" class="mt-1 w-full rounded-md shadow-sm border-gray-300">
                                        <option value="desc" @selected(($filters['sort_direction'] ?? '') === 'desc')>Descendente</option>
                                        <option value="asc" @selected(($filters['sort_direction'] ?? '') === 'asc')>Ascendente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('clients.index') }}" class="text-sm text-gray-600 hover:underline mr-4">Limpiar filtros</a>
                                <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md text-sm">
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI / CUIT</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($clients as $client)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $client->nombre }} {{ $client->apellido }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->dni_cuit }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('clients.show', $client) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                            <a href="{{ route('clients.edit', $client) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Editar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No se encontraron clientes que coincidan con su búsqueda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $clients->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>