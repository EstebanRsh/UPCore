<x-app-layout>
    <x-slot name="header">
        <div class="relative" x-data="{ open: false }">
            <form method="GET" action="{{ route('clients.index') }}">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Gestión de Clientes
                    </h2>

                    <div class="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-2 w-full">
                        <input type="text" name="search" placeholder="Buscar..."
                            class="flex-1 min-w-0 rounded-md shadow-sm border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ $filters['search'] ?? '' }}">

                        <button type="button" @click="open = !open" class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border rounded-md hover:bg-gray-50 whitespace-nowrap">
                            Filtros <span x-text="open ? '▲' : '▼'" class="ml-1"></span>
                        </button>

                        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md text-sm">
                            Filtrar
                        </button>

                        <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 font-bold rounded-md text-sm border">
                            Limpiar
                        </a>
                    </div>
                </div>

                <div x-show="open"
                     x-transition
                     class="mt-2 w-full sm:absolute sm:top-full sm:right-0 sm:w-auto z-20"
                     @click.away="open = false"
                     style="display: none;">
                    
                    <div class="bg-white shadow-lg rounded-lg border p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                                        <input type="text" name="city" id="city" placeholder="Ej: Paraná"
                                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                            value="{{ $filters['city'] ?? '' }}">
                                    </div>

                                    <div>
                                        <label for="date_from" class="block text-sm font-medium text-gray-700">Registrado Desde</label>
                                        <input type="date" name="date_from" id="date_from"
                                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                            value="{{ $filters['date_from'] ?? '' }}">
                                    </div>

                                    <div>
                                        <label for="date_to" class="block text-sm font-medium text-gray-700">Registrado Hasta</label>
                                        <input type="date" name="date_to" id="date_to"
                                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                            value="{{ $filters['date_to'] ?? '' }}">
                                    </div>

                                    <div>
                                        <label for="sort_by" class="block text-sm font-medium text-gray-700">Ordenar por</label>
                                        <select name="sort_by" id="sort_by"
                                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                            <option value="created_at" @selected(($filters['sort_by'] ?? '') === 'created_at')>Fecha de Registro</option>
                                            <option value="nombre" @selected(($filters['sort_by'] ?? '') === 'nombre')>Nombre</option>
                                            <option value="apellido" @selected(($filters['sort_by'] ?? '') === 'apellido')>Apellido</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="sort_direction" class="block text-sm font-medium text-gray-700">Dirección</label>
                                        <select name="sort_direction" id="sort_direction"
                                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                            <option value="desc" @selected(($filters['sort_direction'] ?? '') === 'desc')>Descendente</option>
                                            <option value="asc" @selected(($filters['sort_direction'] ?? '') === 'asc')>Ascendente</option>
                                        </select>
                                    </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-y-auto">
<table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="w-16 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N°</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellido</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI / CUIT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Registro</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($clients as $client)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->index + $clients->firstItem() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $client->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->apellido }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->dni_cuit }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->serviceAddresses->first()->ciudad ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @php
                                            $contract = $client->contracts->first();
                                            $status = $contract->estado ?? 'Sin Contrato';
                                            $bgColor = 'bg-gray-100 text-gray-800'; // Default
                                            if ($status === 'Activo') $bgColor = 'bg-green-100 text-green-800';
                                            if ($status === 'Inactivo') $bgColor = 'bg-red-100 text-red-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $bgColor }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('clients.show', $client) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                        <a href="{{ route('clients.edit', $client) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-20 text-center text-gray-500">
                                        No se encontraron clientes que coincidan con los filtros aplicados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t">
                    {{ $clients->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>