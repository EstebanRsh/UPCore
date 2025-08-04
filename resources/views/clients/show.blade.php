<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles del Cliente: {{ $client->nombre }} {{ $client->apellido }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Éxito</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Información Personal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><strong>Nombre:</strong> {{ $client->nombre }}</div>
                        <div><strong>Apellido:</strong> {{ $client->apellido ?: 'No especificado' }}</div>
                        <div><strong>Email:</strong> {{ $client->user->email }}</div>
                        <div><strong>DNI/CUIT:</strong> {{ $client->dni_cuit ?: 'No especificado' }}</div>
                        <div><strong>Teléfono:</strong> {{ $client->telefono ?: 'No especificado' }}</div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('clients.edit', $client) }}"
                            class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded">Editar
                            Información</a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Direcciones de Servicio</h3>
                        <a href="#"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Añadir
                            Dirección</a>
                    </div>

                    @forelse($client->serviceAddresses as $address)
                        <div class="border-t p-4">
                            <p><strong>Etiqueta:</strong> {{ $address->etiqueta }}</p>
                            <p>{{ $address->direccion }},
                                {{ $address->departamento ? $address->departamento . ',' : '' }}
                                {{ $address->ciudad }}
                            </p>
                            @if ($address->notas)
                                <p class="text-sm text-gray-600 mt-2"><strong>Notas:</strong> {{ $address->notas }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">Este cliente aún no tiene direcciones de servicio registradas.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Contratos del Cliente</h3>
                        <a href="#"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear
                            Contrato</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Plan Contratado</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Fecha de Instalación</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Estado</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse($client->contracts as $contract)
                                    <tr>
                                        <td class="py-3 px-4">{{ $contract->plan->nombre_plan }}</td>
                                        <td class="py-3 px-4">
                                            {{ \Carbon\Carbon::parse($contract->fecha_instalacion)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 px-4">
                                            @php
                                                $color = '';
                                                if ($contract->estado === 'Activo') {
                                                    $color = 'bg-green-200 text-green-800';
                                                } elseif ($contract->estado === 'Suspendido') {
                                                    $color = 'bg-yellow-200 text-yellow-800';
                                                } elseif ($contract->estado === 'Cancelado') {
                                                    $color = 'bg-red-200 text-red-800';
                                                }
                                            @endphp
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight rounded-full text-xs {{ $color }}">
                                                {{ $contract->estado }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-3 px-4 text-center">Este cliente aún no tiene
                                            contratos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
