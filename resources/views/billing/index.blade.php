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

                    @if ($searchTerm && $clients)
                        <div class="mt-6 border-t pt-4">
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
                        </div>
                    @endif
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
                                    <h4 class="font-semibold">Contrato #{{ $contract->id }} - Plan:
                                        {{ $contract->plan->nombre_plan }} ({{ $contract->estado }})</h4>
                                    <div class="mt-2">
                                        <h5 class="text-md font-medium mb-2">Historial de Facturas:</h5>
                                        @if ($contract->invoices->isNotEmpty())
                                            <table class="min-w-full text-sm">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th class="px-4 py-2 text-left">Periodo</th>
                                                        <th class="px-4 py-2 text-left">Monto</th>
                                                        <th class="px-4 py-2 text-left">Estado</th>
                                                        <th class="px-4 py-2 text-left">Pagado el</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($contract->invoices as $invoice)
                                                        <tr class="border-t">
                                                            <td class="px-4 py-2">
                                                                {{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('m/Y') }}
                                                            </td>
                                                            <td class="px-4 py-2">
                                                                ${{ number_format($invoice->monto, 2) }}</td>
                                                            <td class="px-4 py-2">
                                                                <span
                                                                    class="px-2 py-1 font-semibold leading-tight rounded-full text-xs {{ $invoice->estado === 'Pagada' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                                                    {{ $invoice->estado }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-2">
                                                                {{ $invoice->payments->first() ? \Carbon\Carbon::parse($invoice->payments->first()->fecha_pago)->format('d/m/Y') : '---' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="mt-2 text-sm text-gray-500">Este contrato no tiene facturas
                                                registradas.</p>
                                        @endif
                                    </div>
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
