<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Perfil del Cliente
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Vista detallada de {{ $client->nombre }} {{ $client->apellido }}
                </p>
            </div>
            <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 font-bold rounded-md text-sm border">
                &larr; Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-gray-800 border-b pb-3 mb-4">Información de Contacto</h3>
                            <div class="space-y-3 text-sm">
                                <p><strong>DNI/CUIT:</strong> {{ $client->dni_cuit }}</p>
                                <p><strong>Email:</strong> {{ $client->email }}</p>
                                <p><strong>Teléfono:</strong> {{ $client->telefono ?? 'No especificado' }}</p>
                                <p><strong>Cliente desde:</strong> {{ $client->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-gray-800 border-b pb-3 mb-4">Acciones</h3>
                            <div class="space-y-3">
                                <a href="{{ route('billing.createInvoice', $client) }}" class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md text-sm">Generar Cobro Manual</a>
                                <a href="{{ route('clients.edit', $client) }}" class="block w-full text-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-md text-sm">Editar Cliente</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-gray-800 border-b pb-3 mb-4">Contratos Activos</h3>
                            @forelse($client->contracts as $contract)
                                <div class="p-4 border rounded-md mb-3">
                                    <div class="flex justify-between items-center">
                                        <p class="font-bold">{{ $contract->plan->nombre_plan }}</p>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contract->estado === 'Activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $contract->estado }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Dirección: {{ $client->serviceAddresses->first()->direccion ?? 'No especificada' }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Este cliente no tiene contratos registrados.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-gray-800 border-b pb-3 mb-4">Últimas Facturas</h3>
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Periodo</th>
                                        <th class="px-4 py-2 text-left">Monto</th>
                                        <th class="px-4 py-2 text-left">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($client->contracts->flatMap->invoices as $invoice)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('m/Y') }}</td>
                                            <td class="px-4 py-2">${{ number_format($invoice->monto, 2) }}</td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $invoice->estado === 'Pagada' ? 'bg-green-100 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                                    {{ $invoice->estado }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">No hay facturas para mostrar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>