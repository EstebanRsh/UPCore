<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Añadir Nueva Dirección para: {{ $client->nombre }} {{ $client->apellido }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('clients.addresses.store', $client) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="etiqueta" class="block font-medium text-sm text-gray-700">Etiqueta (Ej: Casa,
                                    Oficina)</label>
                                <input id="etiqueta" name="etiqueta" type="text" value="{{ old('etiqueta') }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required />
                            </div>
                            <div>
                                <label for="ciudad" class="block font-medium text-sm text-gray-700">Ciudad</label>
                                <input id="ciudad" name="ciudad" type="text" value="{{ old('ciudad') }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required />
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="direccion" class="block font-medium text-sm text-gray-700">Dirección Completa
                                (Calle y número)</label>
                            <input id="direccion" name="direccion" type="text" value="{{ old('direccion') }}"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required />
                        </div>

                        <div class="mt-4">
                            <label for="departamento" class="block font-medium text-sm text-gray-700">Departamento
                                (Opcional)</label>
                            <input id="departamento" name="departamento" type="text"
                                value="{{ old('departamento') }}"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300" />
                        </div>

                        <div class="mt-4">
                            <label for="notas" class="block font-medium text-sm text-gray-700">Notas
                                (Opcional)</label>
                            <textarea id="notas" name="notas" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('notas') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('clients.show', $client) }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Dirección
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
