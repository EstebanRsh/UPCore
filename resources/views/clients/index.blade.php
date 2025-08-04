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

                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Nombre y Apellido</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Email</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Nº Direcciones</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($clients as $client)
                                <tr>
                                    <td class="py-3 px-4">{{ $client->nombre }} {{ $client->apellido }}</td>
                                    <td class="py-3 px-4">{{ $client->user->email }}</td>
                                    <td class="py-3 px-4 text-center">{{ $client->service_addresses_count }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('clients.show', $client) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
                                            Ver Detalles
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3 px-4 text-center">No hay clientes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
