<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar precio — {{ $plan->nombre_plan }} ({{ $plan->velocidad_mbps }} Mbps)
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded p-6">
            <form method="POST" action="{{ route('settings.planes.update', $plan) }}">
                @csrf
                @method('PUT')


                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input class="mt-1 w-full border rounded p-2 bg-gray-100" value="{{ $plan->nombre_plan }}"
                            disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Velocidad (Mbps)</label>
                        <input class="mt-1 w-full border rounded p-2 bg-gray-100" value="{{ $plan->velocidad_mbps }}"
                            disabled>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Precio mensual</label>
                        <input type="number" step="0.01" name="precio_mensual"
                            value="{{ old('precio_mensual', $plan->precio_mensual) }}"
                            class="mt-1 w-full border rounded p-2" required min="0">
                        @error('precio_mensual')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            Cambiar el precio afecta futuras facturaciones, no las ya emitidas.
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('settings.planes.index') }}" class="px-4 py-2 border rounded">Cancelar</a>

                    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
