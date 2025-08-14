<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generar cobro — {{ $client->nombre }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded p-6">
            <form method="POST" action="{{ route('billing.storeInvoice', $client) }}">
                @csrf

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contrato</label>
                        <select name="contract_id" id="contract_id" class="mt-1 w-full border rounded p-2" required>
                            <option value="">Seleccionar…</option>
                            @foreach ($contracts as $ctr)
                                <option value="{{ $ctr->id }}" data-monto="{{ $ctr->plan->precio ?? '' }}">
                                    #{{ $ctr->id }} — {{ $ctr->plan->nombre ?? 'Plan' }}
                                </option>
                            @endforeach
                        </select>
                        @error('contract_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mes de servicio</label>
                        <input type="month" name="mes_servicio" class="mt-1 w-full border rounded p-2"
                            value="{{ old('mes_servicio', now()->format('Y-m')) }}" required>
                        @error('mes_servicio')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Monto pagado</label>
                        <input type="number" step="0.01" name="monto_pagado" id="monto_pagado"
                            class="mt-1 w-full border rounded p-2" required>
                        @error('monto_pagado')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Método de pago</label>
                        <select name="metodo_pago" class="mt-1 w-full border rounded p-2" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Débito">Débito</option>
                            <option value="Crédito">Crédito</option>
                        </select>
                        @error('metodo_pago')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de pago</label>
                        <input type="date" name="fecha_pago" class="mt-1 w-full border rounded p-2"
                            value="{{ old('fecha_pago', now()->format('Y-m-d')) }}" required>
                        @error('fecha_pago')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Notas</label>
                        <textarea name="notas" rows="3" class="mt-1 w-full border rounded p-2">{{ old('notas') }}</textarea>
                        @error('notas')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('billing.index', ['client_id' => $client->id]) }}"
                        class="px-4 py-2 border rounded">Cancelar</a>
                    <button class="px-4 py-2 bg-emerald-600 text-white rounded">Guardar y generar recibo</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('contract_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var monto = selectedOption.getAttribute('data-monto');
            if (monto) document.getElementById('monto_pagado').value = monto;
        });
    </script>
</x-app-layout>
