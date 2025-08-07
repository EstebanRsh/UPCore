<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nueva Promoción
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('promotions.store') }}">
                        @csrf

                        @if ($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">¡Ups! Hubo algunos problemas con tu entrada.</strong>
                                <ul class="mt-3 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nombre">Nombre de la Promoción</label>
                                <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}"
                                    class="block mt-1 w-full" required />
                            </div>
                            <div>
                                <label for="duracion_meses">Duración (en meses)</label>
                                <input id="duracion_meses" name="duracion_meses" type="number"
                                    value="{{ old('duracion_meses') }}" class="block mt-1 w-full" required />
                            </div>
                            <div>
                                <label for="tipo_descuento">Tipo de Descuento</label>
                                <select id="tipo_descuento" name="tipo_descuento" class="block mt-1 w-full" required>
                                    <option value="porcentaje">Porcentaje (%)</option>
                                    <option value="monto_fijo">Monto Fijo ($)</option>
                                    <option value="meses_gratis">Meses Gratis</option>
                                </select>
                            </div>
                            <div>
                                <label for="valor_descuento">Valor del Descuento</label>
                                <input id="valor_descuento" name="valor_descuento" type="number" step="0.01"
                                    value="{{ old('valor_descuento') }}" class="block mt-1 w-full" required />
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" rows="4" class="block mt-1 w-full" required>{{ old('descripcion') }}</textarea>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('promotions.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Promoción
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
