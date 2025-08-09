<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr> 
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI / CUIT</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($clients as $client)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $client->nombre }} {{ $client->apellido }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->dni_cuit }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->telefono ?? 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    {{-- CAMBIOS AQUÍ: Enlaces funcionales --}}
                    <a href="{{ route('clients.show', $client) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                    <a href="{{ route('clients.edit', $client) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Editar</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
