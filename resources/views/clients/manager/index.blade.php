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

                    <div x-data="{ open: false }">
                        <form method="GET" action="{{ route('clients.index') }}">
                            <div class="flex flex-col sm:flex-row items-center gap-4 mb-4">
                                <input type="text" name="search" placeholder="Buscar por nombre, apellido o DNI..."
                                    class="w-full sm:w-2/5 rounded-md shadow-sm border-gray-300"
                                    value="{{ $filters['search'] ?? '' }}">

                                <button type="button" @click="open = !open" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 whitespace-nowrap">
                                    Filtros Avanzados
                                    <span x-text="open ? '▲' : '▼'" class="ml-1"></span>
                                </button>

                                <div class="flex-grow flex justify-start sm:justify-end gap-2">
                                    <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md text-sm">
                                        Filtrar
                                    </button>
                                    <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 font-bold rounded-md text-sm border">
                                        Limpiar
                                    </a>
                                </div>
                            </div>

                            <div x-show="open" x-transition class="bg-gray-50 p-4 rounded-lg border">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label for="city" class="text-sm font-medium text-gray-700">Ciudad</label>
                                        <input type="text" name="city" id="city" placeholder="Ej: Paraná"
                                            class="mt-1 w-full rounded-md shadow-sm border-gray-300"
                                            value="{{ $filters['city'] ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="date_from" class="text-sm font-medium text-gray-700">Registrado Desde</label>
                                        <input type="date" name="date_from" id="date_from" class="mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ $filters['date_from'] ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="date_to" class="text-sm font-medium text-gray-700">Registrado Hasta</label>
                                        <input type="date" name="date_to" id="date_to" class="mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ $filters['date_to'] ?? '' }}">
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
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellido</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI / CUIT</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($clients as $client)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $client->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->apellido }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->dni_cuit }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('clients.show', $client) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                            <a href="{{ route('clients.edit', $client) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Editar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No se encontraron clientes que coincidan con los filtros aplicados.
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