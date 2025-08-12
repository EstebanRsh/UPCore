<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Centro de Cobranza
            </h2>
            <form method="GET" action="{{ route('billing.index') }}" class="flex items-center gap-2">
                <input type="text" name="search" placeholder="Buscar cliente para cobrar..."
                    class="w-64 rounded-md shadow-sm border-gray-300 text-sm" value="{{ $searchTerm ?? '' }}">
                <button type="submit"
                    class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md text-sm">
                    Buscar
                </button>
                @if ($searchTerm)
                    <a href="{{ route('billing.index') }}"
                        class="px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 font-bold rounded-md text-sm border">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre Completo</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    DNI / CUIT</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Último Pago</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @for ($i = 0; $i < 10; $i++)
                                @if (isset($clients[$i]))
                                    @php $client = $clients[$i]; @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $client->nombre }} {{ $client->apellido }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $client->dni_cuit }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{-- Lógica para el último pago aquí --}}
                                            N/A
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('billing.createInvoice', $client) }}"
                                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-md text-xs transition-colors">
                                                <span class="font-bold text-base">$</span>
                                                Generar Cobro
                                            </a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="px-6 py-4" colspan="4" style="height: 57px;"></td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 truncate">Ingresos (Este Mes)</h3>
                    <p class="mt-1 text-3xl font-semibold text-green-600">
                        ${{ number_format($stats['revenue_this_month'], 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 truncate">Facturas Pendientes</h3>
                    <p class="mt-1 text-3xl font-semibold text-yellow-600">{{ $stats['pending_invoices_count'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 truncate">Monto Pendiente Total</h3>
                    <p class="mt-1 text-3xl font-semibold text-red-600">
                        ${{ number_format($stats['total_pending_amount'], 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 truncate">Pagos Registrados Hoy</h3>
                    <p class="mt-1 text-3xl font-semibold text-blue-600">{{ $stats['payments_today'] }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
