<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Pago para Factura #{{ $invoice->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Detalles de la Deuda</h3>
                        <p><strong>Cliente:</strong> {{ $invoice->contract->client->nombre }}
                            {{ $invoice->contract->client->apellido }}</p>
                        <p><strong>Contrato:</strong> #{{ $invoice->contract->id }} - Plan
                            {{ $invoice->contract->plan->nombre_plan }}</p>
                        <p><strong>Monto de la Factura:</strong> ${{ number_format($invoice->monto, 2) }}</p>
                    </div>

                    <form method="POST" action="{{ route('payments.store', $invoice) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="monto_pagado">Monto a Pagar</label>
                                <input type="number" step="0.01" name="monto_pagado" id="monto_pagado"
                                    value="{{ old('monto_pagado', $invoice->monto) }}" class="block mt-1 w-full"
                                    required>
                            </div>
                            <div>
                                <label for="metodo_pago">Método de Pago</label>
                                <select name="metodo_pago" id="metodo_pago" class="block mt-1 w-full" required>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                                    <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                                </select>
                            </div>
                            <div>
                                <label for="fecha_pago">Fecha de Pago</label>
                                <input type="date" name="fecha_pago" id="fecha_pago"
                                    value="{{ old('fecha_pago', now()->format('Y-m-d')) }}" class="block mt-1 w-full"
                                    required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="notas">Notas (Opcional)</label>
                            <textarea name="notas" id="notas" rows="3" class="block mt-1 w-full">{{ old('notas') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('billing.index', ['client_id' => $invoice->contract->client->id]) }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Confirmar Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
