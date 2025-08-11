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
            <a href="{{ route('clients.index') }}"
                class="px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 font-bold rounded-md text-sm border">
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
                            <h3 class="font-semibold text-lg text-gray-800 border-b pb-3 mb-4">Información de Contacto
                            </h3>
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
                                <a href="{{ route('billing.createInvoice', $client) }}"
                                    class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md text-sm">Generar
                                    Cobro Manual</a>
                                <a href="{{ route('clients.edit', $client) }}"
                                    class="block w-full text-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-md text-sm">Editar
                                    Cliente</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-gray-800 border-b pb-3 mb-4">Bitácora / Notas</h3>
                            <form action="{{ route('clients.notes.store', $client) }}" method="POST" class="mb-4">
                                @csrf
                                <textarea name="note" rows="3"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                    placeholder="Añadir una nueva nota sobre el cliente..." required></textarea>
                                <div class="text-right mt-2">
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-md text-xs">Guardar
                                        Nota</button>
                                </div>
                            </form>

                            <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                                @forelse($client->notes as $note)
                                    <div class="p-3 bg-gray-50 rounded-lg border text-sm" x-data="{ editing: false, noteContent: `{{ $note->note }}` }">
                                        <div x-show="!editing">
                                            <p class="text-gray-700 whitespace-pre-wrap">{{ $note->note }}</p>
                                        </div>
                                        <div x-show="editing" style="display: none;">
                                            <form action="{{ route('clients.notes.update', $note) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <textarea name="note" rows="3" class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                                    x-model="noteContent"></textarea>
                                                <div class="text-right mt-2 space-x-2">
                                                    <button type="button"
                                                        @click="editing = false; noteContent = `{{ $note->note }}`"
                                                        class="px-3 py-1.5 bg-white text-gray-700 border rounded-md text-xs">Cancelar</button>
                                                    <button type="submit"
                                                        class="px-3 py-1.5 bg-indigo-600 text-white rounded-md text-xs">Guardar</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="flex justify-between items-center mt-2">
                                            <p class="text-xs text-gray-500">
                                                Por <strong>{{ $note->user->name }}</strong> el
                                                {{ $note->created_at->format('d/m/y H:i') }}
                                            </p>
                                            <div class="flex items-center gap-2" x-show="!editing">
                                                <button @click="editing = true"
                                                    class="text-xs text-yellow-600 hover:underline">Editar</button>
                                                <form action="{{ route('clients.notes.destroy', $note) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar esta nota?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs text-red-600 hover:underline">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-center text-gray-500 py-4">No hay notas para este cliente.
                                    </p>
                                @endforelse
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
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contract->estado === 'Activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $contract->estado }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Dirección:
                                        {{ $client->serviceAddresses->first()->direccion ?? 'No especificada' }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Este cliente no tiene contratos registrados.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-gray-800 border-b pb-3 mb-4">Historial de Facturación
                            </h3>

                            <form method="GET" action="{{ route('clients.show', $client) }}" class="mb-4">
                                <div class="flex items-center gap-4 text-sm">
                                    <div>
                                        <label for="invoice_period" class="sr-only">Período</label>
                                        <input type="month" name="invoice_period" id="invoice_period"
                                            class="rounded-md shadow-sm border-gray-300"
                                            value="{{ $invoiceFilters['invoice_period'] ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="invoice_status" class="sr-only">Estado</label>
                                        <select name="invoice_status" id="invoice_status"
                                            class="rounded-md shadow-sm border-gray-300">
                                            <option value="">-- Todos los estados --</option>
                                            <option value="Pagada" @selected(($invoiceFilters['invoice_status'] ?? '') === 'Pagada')>Pagada</option>
                                            <option value="Pendiente" @selected(($invoiceFilters['invoice_status'] ?? '') === 'Pendiente')>Pendiente</option>
                                        </select>
                                    </div>
                                    <button type="submit"
                                        class="px-4 py-2 bg-gray-800 text-white font-bold rounded-md">Filtrar</button>
                                    <a href="{{ route('clients.show', $client) }}"
                                        class="px-4 py-2 bg-white text-gray-700 font-bold rounded-md border">Limpiar</a>
                                </div>
                            </form>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left">N° Factura</th>
                                            <th class="px-4 py-2 text-left">Período</th>
                                            <th class="px-4 py-2 text-left">Monto</th>
                                            <th class="px-4 py-2 text-left">Estado</th>
                                            <th class="px-4 py-2 text-left">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($invoices as $invoice)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 font-medium">#{{ $invoice->id }}</td>
                                                <td class="px-4 py-2">
                                                    {{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('m/Y') }}
                                                </td>
                                                <td class="px-4 py-2">${{ number_format($invoice->monto, 2) }}</td>
                                                <td class="px-4 py-2">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $invoice->estado === 'Pagada' ? 'bg-green-100 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                                        {{ $invoice->estado }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2">
                                                    @if ($invoice->pdf_filename)
                                                        <a href="{{ route('invoices.pdf', $invoice) }}"
                                                            target="_blank"
                                                            class="text-indigo-600 hover:text-indigo-900">Ver PDF</a>
                                                    @else
                                                        <span class="text-gray-400">Sin PDF</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">No hay
                                                    facturas que coincidan con los filtros.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $invoices->appends($invoiceFilters)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
