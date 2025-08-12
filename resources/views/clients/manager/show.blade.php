<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-slate-100 border-2 border-slate-300 rounded-lg flex items-center justify-center text-slate-600 font-semibold text-lg">
                    {{ strtoupper(substr($client->nombre, 0, 1) . substr($client->apellido, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-slate-800">
                        {{ $client->nombre }} {{ $client->apellido }}
                    </h2>
                    <p class="text-sm text-slate-500 mt-1 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Cliente desde {{ $client->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>
            <a href="{{ route('clients.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 font-medium rounded-lg border border-slate-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                <!-- Sidebar -->
                <div class="xl:col-span-1 space-y-6">

                    <!-- Quick Actions - MOVED TO TOP -->
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                        <div class="border-b border-slate-200 p-4">
                            <h3 class="text-lg font-medium text-slate-800">Acciones Rápidas</h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <!-- Primary Action - Generate Invoice with $ symbol -->
                            <a href="{{ route('billing.createInvoice', $client) }}"
                                class="flex items-center gap-3 w-full p-4 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 hover:border-emerald-300 rounded-lg transition-all group">
                                <div
                                    class="w-10 h-10 bg-emerald-100 group-hover:bg-emerald-200 rounded-lg flex items-center justify-center transition-colors">
                                    <span class="text-emerald-600 font-bold text-lg">$</span>
                                </div>
                                <div class="flex-1">
                                    <span class="font-semibold text-emerald-800 block">Generar Cobro Manual</span>
                                    <span class="text-xs text-emerald-600">Nueva factura</span>
                                </div>
                                <svg class="w-4 h-4 text-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <!-- Secondary Action - Edit Client -->
                            <a href="{{ route('clients.edit', $client) }}"
                                class="flex items-center gap-3 w-full p-4 bg-slate-50 hover:bg-slate-100 border border-slate-200 hover:border-blue-300 rounded-lg transition-all group">
                                <div
                                    class="w-10 h-10 bg-slate-100 group-hover:bg-blue-100 rounded-lg flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5 text-slate-600 group-hover:text-blue-600 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <span
                                        class="font-semibold text-slate-700 group-hover:text-blue-700 transition-colors block">Editar
                                        Cliente</span>
                                    <span
                                        class="text-xs text-slate-500 group-hover:text-blue-600 transition-colors">Modificar
                                        datos</span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                        <div class="border-b border-slate-200 p-4">
                            <h3 class="text-lg font-medium text-slate-800">Información de Contacto</h3>
                        </div>
                        <div class="p-4 space-y-4">
                            <div class="flex items-start gap-3 p-3 border border-slate-100 rounded-lg">
                                <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">DNI/CUIT</p>
                                    <p class="text-sm font-medium text-slate-800 mt-1">{{ $client->dni_cuit }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3 border border-slate-100 rounded-lg">
                                <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Email</p>
                                    <p class="text-sm font-medium text-slate-800 mt-1 break-all">{{ $client->email }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3 border border-slate-100 rounded-lg">
                                <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Teléfono</p>
                                    <p class="text-sm font-medium text-slate-800 mt-1">
                                        {{ $client->telefono ?? 'No especificado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                        <div class="border-b border-slate-200 p-4">
                            <h3 class="text-lg font-medium text-slate-800">Bitácora / Notas</h3>
                        </div>
                        <div class="p-4">
                            <form action="{{ route('clients.notes.store', $client) }}" method="POST"
                                class="mb-4">
                                @csrf
                                <div class="relative">
                                    <textarea name="note" rows="3"
                                        class="w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring-blue-400 focus:ring-1 text-sm resize-none"
                                        placeholder="Añadir una nueva nota sobre el cliente..." required></textarea>
                                    <div class="absolute bottom-3 right-3">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-700 hover:bg-slate-800 text-white text-xs font-medium rounded-md transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="space-y-3 max-h-80 overflow-y-auto">
                                @forelse($client->notes as $note)
                                    <div class="group p-4 border border-slate-200 hover:border-slate-300 rounded-lg bg-slate-50 hover:bg-white transition-all"
                                        x-data="{ editing: false, noteContent: `{{ $note->note }}` }">
                                        <div x-show="!editing">
                                            <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap">
                                                {{ $note->note }}</p>
                                        </div>
                                        <div x-show="editing" style="display: none;">
                                            <form action="{{ route('clients.notes.update', $note) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <textarea name="note" rows="3"
                                                    class="w-full border-slate-300 rounded-lg shadow-sm text-sm mb-3 focus:border-blue-400 focus:ring-blue-400 focus:ring-1"
                                                    x-model="noteContent"></textarea>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button"
                                                        @click="editing = false; noteContent = `{{ $note->note }}`"
                                                        class="px-3 py-1.5 bg-white text-slate-600 border border-slate-300 rounded-md text-xs hover:bg-slate-50">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit"
                                                        class="px-3 py-1.5 bg-slate-700 hover:bg-slate-800 text-white rounded-md text-xs">
                                                        Guardar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="flex justify-between items-center mt-3">
                                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                                <div
                                                    class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-slate-600">
                                                        {{ strtoupper(substr($note->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <span>Por <strong
                                                        class="text-slate-700">{{ $note->user->name }}</strong> el
                                                    {{ $note->created_at->format('d/m/y H:i') }}</span>
                                            </div>
                                            <div class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity"
                                                x-show="!editing">
                                                <button @click="editing = true"
                                                    class="text-xs text-slate-500 hover:text-blue-600 font-medium">Editar</button>
                                                <form action="{{ route('clients.notes.destroy', $note) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar esta nota?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs text-slate-500 hover:text-red-600 font-medium">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <div
                                            class="w-12 h-12 mx-auto bg-slate-100 rounded-lg flex items-center justify-center mb-4">
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-sm text-slate-500">No hay notas para este cliente</p>
                                        <p class="text-xs text-slate-400 mt-1">Añade la primera nota usando el
                                            formulario anterior</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="xl:col-span-2 space-y-6">

                    <!-- Active Contracts -->
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                        <div class="border-b border-slate-200 p-4">
                            <h3 class="text-lg font-medium text-slate-800">Contratos Activos</h3>
                        </div>
                        <div class="p-4">
                            @forelse($client->contracts as $contract)
                                <div
                                    class="p-4 border border-slate-200 hover:border-slate-300 rounded-lg mb-3 bg-slate-50 hover:bg-white transition-all">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h4 class="font-semibold text-slate-800">
                                                    {{ $contract->plan->nombre_plan }}</h4>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                                    {{ $contract->estado === 'Activo' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                                    {{ $contract->estado }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>{{ $client->serviceAddresses->first()->direccion ?? 'Dirección no especificada' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <div
                                        class="w-12 h-12 mx-auto bg-slate-100 rounded-lg flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-slate-500">Este cliente no tiene contratos registrados</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Billing History -->
                    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                        <div class="border-b border-slate-200 p-4">
                            <h3 class="text-lg font-medium text-slate-800">Historial de Facturación</h3>
                        </div>
                        <div class="p-4">

                            <!-- Filters -->
                            <form method="GET" action="{{ route('clients.show', $client) }}" class="mb-6">
                                <div class="flex flex-wrap items-end gap-4">
                                    <div class="flex-1 min-w-0">
                                        <label for="invoice_period"
                                            class="block text-xs font-medium text-slate-600 mb-2 uppercase tracking-wide">Período</label>
                                        <input type="month" name="invoice_period" id="invoice_period"
                                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 focus:ring-1 text-sm"
                                            value="{{ $invoiceFilters['invoice_period'] ?? '' }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <label for="invoice_status"
                                            class="block text-xs font-medium text-slate-600 mb-2 uppercase tracking-wide">Estado</label>
                                        <select name="invoice_status" id="invoice_status"
                                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 focus:ring-1 text-sm">
                                            <option value="">-- Todos los estados --</option>
                                            <option value="Pagada" @selected(($invoiceFilters['invoice_status'] ?? '') === 'Pagada')>Pagada</option>
                                            <option value="Pendiente" @selected(($invoiceFilters['invoice_status'] ?? '') === 'Pendiente')>Pendiente</option>
                                        </select>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="px-4 py-2 bg-slate-700 hover:bg-slate-800 text-white font-medium rounded-lg text-sm transition-colors">
                                            Filtrar
                                        </button>
                                        <a href="{{ route('clients.show', $client) }}"
                                            class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 font-medium rounded-lg border border-slate-300 text-sm transition-colors">
                                            Limpiar
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <!-- Invoice Table -->
                            <div class="border border-slate-200 rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                N° Factura
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Período
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Monto
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Estado
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        @forelse($invoices as $invoice)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="text-sm font-medium text-slate-900">#{{ $invoice->id }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm text-slate-600">
                                                        {{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('m/Y') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm font-semibold text-slate-800">
                                                        ${{ number_format($invoice->monto, 2) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                                        {{ $invoice->estado === 'Pagada' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                                        {{ $invoice->estado }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if ($invoice->pdf_filename)
                                                        <a href="{{ route('invoices.pdf', $invoice) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-medium transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                            Ver PDF
                                                        </a>
                                                    @else
                                                        <span class="text-slate-400 text-sm">Sin PDF</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-12">
                                                    <div class="text-center">
                                                        <div
                                                            class="w-12 h-12 mx-auto bg-slate-100 rounded-lg flex items-center justify-center mb-4">
                                                            <svg class="w-6 h-6 text-slate-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <p class="text-sm text-slate-500">No hay facturas que coincidan
                                                            con los filtros</p>
                                                        <p class="text-xs text-slate-400 mt-1">Intenta cambiar los
                                                            filtros o generar una nueva factura</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($invoices->hasPages())
                                <div class="mt-6 flex justify-center">
                                    {{ $invoices->appends($invoiceFilters)->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
