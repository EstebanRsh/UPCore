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
                    <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium mb-4">Acciones de Facturación</h3>
                            <form action="{{ route('billing.generateInvoices') }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres generar las facturas para el mes actual? Este proceso se ejecutará en segundo plano.');">
                                @csrf
                                <button type="submit"
                                    class="bg-purple-600 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded">
                                    Generar Facturas del Mes
                                </button>
                            </form>
                        </div>
                    </div>
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
                        <h3 class="text-lg font-medium mb-4">
                            Detalles de Facturación para: <span class="font-bold">{{ $selectedClient->nombre }}
                                {{ $selectedClient->apellido }}</span>
                        </h3>
                        <div class="space-y-6">
                            @forelse ($selectedClient->contracts as $contract)
                                <div class="border rounded-lg p-4">
                                    <div class="font-semibold">Contrato #{{ $contract->id }} - Plan:
                                        {{ $contract->plan->nombre_plan }} ({{ $contract->estado }})</div>
                                    @if ($contract->invoices->isNotEmpty())
                                        <table class="min-w-full mt-2">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-2">Factura ID</th>
                                                    <th class="px-4 py-2">Monto</th>
                                                    <th class="px-4 py-2">Fecha Vencimiento</th>
                                                    <th class="px-4 py-2">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($contract->invoices as $invoice)
                                                    <tr class="border-b">
                                                        <td class="px-4 py-2">{{ $invoice->id }}</td>
                                                        <td class="px-4 py-2">${{ number_format($invoice->monto, 2) }}
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            {{ \Carbon\Carbon::parse($invoice->fecha_vencimiento)->format('d/m/Y') }}
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            <a href="{{ route('payments.create', $invoice) }}"
                                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                                Pagar
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
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

                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">
                            Opción 2 y 3: Aplicar Promoción o Pago Adelantado
                        </h3>
                        <form action="{{ route('billing.processPayment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $selectedClient->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="contract_id">Seleccionar Contrato</label>
                                    <select name="contract_id" id="contract_id" class="block mt-1 w-full" required>
                                        @foreach ($selectedClient->contracts as $contract)
                                            <option value="{{ $contract->id }}">
                                                Contrato #{{ $contract->id }} (Plan:
                                                {{ $contract->plan->nombre_plan }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="promotion_id">Seleccionar Promoción</label>
                                    <select name="promotion_id" id="promotion_id" class="block mt-1 w-full">
                                        <option value="">-- Pago manual sin promo --</option>
                                        @foreach ($promotions as $promo)
                                            <option value="{{ $promo->id }}">{{ $promo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="meses_a_pagar">Meses a Pagar (si no usa promo)</label>
                                    <input type="number" name="meses_a_pagar" id="meses_a_pagar"
                                        class="block mt-1 w-full" min="1" value="1">
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-6">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                    Calcular y Proceder al Pago
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
