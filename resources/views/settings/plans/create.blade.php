<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo plan</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded p-6">
            <form method="POST" action="{{ route('settings.planes.store') }}">

                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input name="nombre_plan" value="{{ old('nombre_plan') }}" class="mt-1 w-full border rounded p-2"
                        required>
                    @error('nombre_plan')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Velocidad (Mbps)</label>
                    <input type="number" name="velocidad_mbps" value="{{ old('velocidad_mbps') }}"
                        class="mt-1 w-full border rounded p-2" required min="1">
                    @error('velocidad_mbps')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Precio mensual</label>
                    <input type="number" step="0.01" name="precio_mensual" value="{{ old('precio_mensual') }}"
                        class="mt-1 w-full border rounded p-2" required min="0">
                    @error('precio_mensual')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Descripción (opcional)</label>
                    <textarea name="descripcion" rows="3" class="mt-1 w-full border rounded p-2">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="activo" value="1" class="mr-2" checked>
                        Activo
                    </label>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('settings.planes.index') }}" class="px-4 py-2 border rounded">Cancelar</a>

                    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
