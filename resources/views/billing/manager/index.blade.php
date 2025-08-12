<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Centro de Cobranza
            </h2>
            <form method="GET" action="{{ route('billing.index') }}" class="flex items-center gap-2">
                <input type="text" name="search" placeholder="Buscar cliente por nombre, DNI..."
                    class="w-64 rounded-md shadow-sm border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ $searchTerm ?? '' }}">
                <button type="submit"
                    class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md text-sm">
                    Buscar
                </button>
                @if ($searchTerm || request('client_id'))
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            @if (isset($selectedClient))
                                <div class="border rounded-lg p-4 bg-slate-50">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="text-xl font-bold text-slate-800">{{ $selectedClient->nombre }}
                                                {{ $selectedClient->apellido }}</h4>
                                            <p class="text-sm text-slate-600">DNI/CUIT: {{ $selectedClient->dni_cuit }}
                                            </p>
                                        </div>
                                        <a href="{{ route('billing.createInvoice', $selectedClient) }}"
                                            class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md text-xs whitespace-nowrap">+
                                            Nuevo Cobro</a>
                                    </div>
                                    <div class="mt-4 border-t pt-4">
                                        <h5 class="font-semibold mb-2 text-slate-700">Historial de Facturas</h5>
                                        <div class="max-h-80 overflow-y-auto pr-2">
                                            @forelse($selectedClient->invoices as $invoice)
                                                <div
                                                    class="flex justify-between items-center text-sm py-2 {{ !$loop->last ? 'border-b border-slate-200' : '' }}">
                                                    <p class="text-slate-600">Período
                                                        {{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('m/Y') }}
                                                        - ${{ number_format($invoice->monto, 2) }}</p>
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $invoice->estado === 'Pagada' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $invoice->estado }}</span>
                                                </div>
                                            @empty
                                                <p class="text-sm text-slate-500 py-4 text-center">Sin facturas.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @elseif(isset($clients))
                                @if ($clients->isEmpty())
                                    <p class="text-sm text-center text-gray-500 py-8">No se encontraron clientes para
                                        "{{ $searchTerm }}".</p>
                                @else
                                    <ul class="space-y-2">
                                        @foreach ($clients as $client)
                                            <li class="p-3 bg-slate-50 rounded-md hover:bg-slate-100 transition-colors">
                                                <a href="{{ route('billing.index', ['client_id' => $client->id, 'search' => $searchTerm]) }}"
                                                    class="font-bold text-indigo-600">
                                                    {{ $client->nombre }} {{ $client->apellido }}
                                                </a>
                                                <span class="text-sm text-slate-600 ml-4">DNI/CUIT:
                                                    {{ $client->dni_cuit }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @else
                                <div class="text-center text-slate-500 py-16">
                                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-slate-900">Comienza una búsqueda</h3>
                                    <p class="mt-1 text-sm text-slate-500">Utilice el buscador en la parte superior para
                                        encontrar un cliente.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-slate-800 border-b pb-3 mb-4">Últimos Pagos
                                Registrados</h3>
                            <div class="space-y-4">
                                @forelse($latestPayments as $payment)
                                    <div class="text-sm">
                                        <p class="font-medium text-slate-800">
                                            ${{ number_format($payment->monto_pagado, 2) }} -
                                            {{ $payment->invoice->contract->client->nombre ?? 'N/A' }}</p>
                                        <p class="text-xs text-slate-500">
                                            {{ \Carbon\Carbon::parse($payment->fecha_pago)->diffForHumans() }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-slate-500">No hay pagos recientes.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-slate-800 border-b pb-3 mb-4">Facturas Pendientes</h3>
                            <div class="space-y-4">
                                @forelse($pendingInvoices as $invoice)
                                    <div class="text-sm">
                                        <p class="font-medium text-slate-800">${{ number_format($invoice->monto, 2) }}
                                            - {{ $invoice->contract->client->nombre ?? 'N/A' }}</p>
                                        <p class="text-xs text-red-500">Vence:
                                            {{ \Carbon\Carbon::parse($invoice->fecha_vencimiento)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                @empty
                                    <p class="text-sm text-slate-500">No hay facturas pendientes.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
