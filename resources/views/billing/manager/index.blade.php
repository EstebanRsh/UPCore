<x-app-layout>
    <x-slot name="header">
        <div class="relative" x-data="{ open: false }">
            <form method="GET" action="{{ route('billing.index') }}">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Centro de Cobranza
                    </h2>
                    <div class="flex items-center gap-2">
                        <input type="text" name="search" placeholder="Buscar..."
                            class="w-48 rounded-md shadow-sm border-gray-300 text-sm"
                            value="{{ $filters['search'] ?? '' }}">
                        <button type="button" @click="open = !open"
                            class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border rounded-md hover:bg-gray-50 whitespace-nowrap">
                            Filtros <span x-text="open ? '▲' : '▼'" class="ml-1"></span>
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md text-sm">Filtrar</button>
                        <a href="{{ route('billing.index') }}"
                            class="px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 font-bold rounded-md text-sm border">Limpiar</a>
                    </div>
                </div>
                <div x-show="open" x-transition class="absolute top-full right-0 w-full md:w-auto mt-2 z-20"
                    @click.away="open = false" style="display: none;">
                    <div class="bg-white shadow-lg rounded-lg border p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="text-xs font-medium text-gray-700">Ciudad</label>
                                <input type="text" name="city" id="city" placeholder="Ej: Paraná"
                                    class="mt-1 w-full rounded-lg border-gray-300 text-sm"
                                    value="{{ $filters['city'] ?? '' }}">
                            </div>
                            <div>
                                <label for="sort_by" class="text-xs font-medium text-gray-700">Ordenar por</label>
                                <select name="sort_by" id="sort_by"
                                    class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                                    <option value="created_at" @selected(($filters['sort_by'] ?? '') === 'created_at')>Fecha de Registro</option>
                                    <option value="nombre" @selected(($filters['sort_by'] ?? '') === 'nombre')>Nombre</option>
                                    <option value="apellido" @selected(($filters['sort_by'] ?? '') === 'apellido')>Apellido</option>
                                </select>
                            </div>
                            <div>
                                <label for="sort_direction" class="text-xs font-medium text-gray-700">Dirección</label>
                                <select name="sort_direction" id="sort_direction"
                                    class="mt-1 w-full rounded-lg border-gray-300 text-sm">
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
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="w-16 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    N°</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Apellido</th>
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
                            @for ($i = 0; $i < 5; $i++)
                                @if (isset($clients[$i]))
                                    @php $client = $clients[$i]; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-2 text-sm text-gray-500">{{ $clients->firstItem() + $i }}
                                        </td>
                                        <td class="px-6 py-2 text-sm font-medium text-gray-900">{{ $client->nombre }}
                                        </td>
                                        <td class="px-6 py-2 text-sm text-gray-500">{{ $client->apellido }}</td>
                                        <td class="px-6 py-2 text-sm text-gray-500">{{ $client->dni_cuit }}</td>
                                        <td class="px-6 py-2 text-sm text-gray-500">
                                            {{ $client->payments->first() ? \Carbon\Carbon::parse($client->payments->first()->fecha_pago)->format('d/m/Y') : 'Sin Pagos' }}
                                        </td>
                                        <td class="px-6 py-2 text-right">
                                            <a href="{{ route('billing.createInvoice', $client) }}"
                                                class="inline-flex items-center gap-3 p-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 hover:border-emerald-300 rounded-lg transition-all group">
                                                <div
                                                    class="w-8 h-8 bg-emerald-100 group-hover:bg-emerald-200 rounded-lg flex items-center justify-center transition-colors">
                                                    <span class="text-emerald-600 font-bold text-base">$</span>
                                                </div>
                                                <div class="text-left">
                                                    <span class="font-semibold text-emerald-800 block text-xs">Generar
                                                        Cobro</span>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="px-6 py-4" colspan="6" style="height: 64px;"></td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
                @if ($clients->hasPages())
                    <div class="p-4 border-t">
                        {{ $clients->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 truncate">Ingresos (Este Mes)</h3>
                    <p class="mt-1 text-3xl font-semibold text-green-600">
                        ${{ number_format($stats['revenue_this_month'] ?? 0, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 truncate">Facturas Pendientes</h3>
                    <p class="mt-1 text-3xl font-semibold text-yellow-600">{{ $stats['pending_invoices_count'] ?? 0 }}
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 truncate">Monto Pendiente Total</h3>
                    <p class="mt-1 text-3xl font-semibold text-red-600">
                        ${{ number_format($stats['total_pending_amount'] ?? 0, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 truncate">Pagos Registrados Hoy</h3>
                    <p class="mt-1 text-3xl font-semibold text-blue-600">{{ $stats['paid_invoices_this_month'] ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
