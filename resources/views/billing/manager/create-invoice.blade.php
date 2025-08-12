<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generar Cobro para: {{ $client->nombre }} {{ $client->apellido }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('billing.storeInvoice', $client) }}">
                        @csrf
                        <h3 class="text-lg font-medium mb-4">Detalles del Cobro</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="contract_id" class="block font-medium text-sm text-gray-700">Contrato a
                                    Cobrar</label>
                                <select name="contract_id" id="contract_id" class="block mt-1 w-full" required>
                                    <option value="">-- Seleccione un Contrato --</option>
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}"
                                            data-monto="{{ $contract->plan->precio_mensual }}">
                                            #{{ $contract->id }} - {{ $contract->plan->nombre_plan }}
                                            (${{ number_format($contract->plan->precio_mensual, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="mes_servicio" class="block font-medium text-sm text-gray-700">Mes de
                                    Servicio</label>
                                <input type="month" name="mes_servicio" id="mes_servicio"
                                    value="{{ now()->format('Y-m') }}" class="block mt-1 w-full" required>
                            </div>
                        </div>

                        <hr class="my-6">
                        <h3 class="text-lg font-medium mb-4">Detalles del Pago</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="monto_pagado" class="block font-medium text-sm text-gray-700">Monto a
                                    Pagar</label>
                                <input type="number" step="0.01" name="monto_pagado" id="monto_pagado"
                                    class="block mt-1 w-full" required>
                            </div>
                            <div>
                                <label for="metodo_pago" class="block font-medium text-sm text-gray-700">Método de
                                    Pago</label>
                                <select name="metodo_pago" id="metodo_pago" class="block mt-1 w-full" required>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Débito">Débito</option>
                                    <option value="Crédito">Crédito</option>
                                </select>
                            </div>
                            <div>
                                <label for="fecha_pago" class="block font-medium text-sm text-gray-700">Fecha de
                                    Pago</label>
                                <input type="date" name="fecha_pago" id="fecha_pago"
                                    value="{{ now()->format('Y-m-d') }}" class="block mt-1 w-full" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('billing.index', ['client_id' => $client->id]) }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Confirmar y Generar Recibo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('contract_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var monto = selectedOption.getAttribute('data-monto');
            document.getElementById('monto_pagado').value = monto;
        });
    </script>
</x-app-layout>
