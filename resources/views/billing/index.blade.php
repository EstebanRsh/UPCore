<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Módulo de Facturación y Pagos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Buscar Cliente</h3>
                    <form action="{{ route('billing.index') }}" method="GET">
                        <div class="flex items-center">
                            <input type="text" name="search" placeholder="Buscar por nombre, apellido o DNI/CUIT..."
                                class="w-full rounded-md shadow-sm border-gray-300" value="{{ request('search') }}">
                            <button type="submit"
                                class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Buscar
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 border-t pt-4">
                        @if ($searchTerm && $clients)
                            <h4 class="font-semibold mb-2">Resultados para "{{ $searchTerm }}":</h4>
                            @if ($clients->isEmpty())
                                <p>No se encontraron clientes.</p>
                            @else
                                <ul class="space-y-2">
                                    @foreach ($clients as $client)
                                        <li class="p-3 bg-gray-50 rounded-md">
                                            <a href="{{ route('billing.index', ['client_id' => $client->id, 'search' => $searchTerm]) }}"
                                                class="font-bold text-indigo-600 hover:underline">
                                                {{ $client->nombre }} {{ $client->apellido }}
                                            </a>
                                            <span class="text-sm text-gray-600 ml-4">DNI/CUIT:
                                                {{ $client->dni_cuit }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            @if ($selectedClient)
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">
                                Estado de Cuenta de: <span class="font-bold">{{ $selectedClient->nombre }}
                                    {{ $selectedClient->apellido }}</span>
                            </h3>
                            <a href="{{ route('billing.createInvoice', $selectedClient) }}"
                                class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">
                                Generar Cobro Manual
                            </a>
                        </div>

                        <div class="space-y-6">
                            @forelse ($selectedClient->contracts as $contract)
                                <div class="border rounded-lg p-4">
                                    <div class="font-semibold">Contrato #{{ $contract->id }} - Plan:
                                        {{ $contract->plan->nombre_plan }} ({{ $contract->estado }})</div>
                                    @if ($contract->invoices->isNotEmpty())
                                        <h4 class="text-md font-semibold mt-2">Facturas Pendientes:</h4>
                                        <table class="min-w-full mt-2">
                                        </table>
                                    @else
                                        <p class="mt-2 text-sm text-green-600">Este contrato está al día (sin facturas
                                            pendientes).</p>
                                    @endif
                                </div>
                            @empty
                                <p>Este cliente no tiene contratos activos.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
