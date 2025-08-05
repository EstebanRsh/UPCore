<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editando Dirección: {{ $address->etiqueta }} (de {{ $client->nombre }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST"
                        action="{{ route('clients.addresses.update', ['client' => $client, 'address' => $address]) }}">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="etiqueta">Etiqueta</label>
                                <input id="etiqueta" name="etiqueta" type="text"
                                    value="{{ old('etiqueta', $address->etiqueta) }}" class="block mt-1 w-full"
                                    required />
                            </div>
                            <div>
                                <label for="ciudad">Ciudad</label>
                                <input id="ciudad" name="ciudad" type="text"
                                    value="{{ old('ciudad', $address->ciudad) }}" class="block mt-1 w-full" required />
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="direccion">Dirección Completa</label>
                            <input id="direccion" name="direccion" type="text"
                                value="{{ old('direccion', $address->direccion) }}" class="block mt-1 w-full"
                                required />
                        </div>
                        <div class="mt-4">
                            <label for="departamento">Departamento (Opcional)</label>
                            <input id="departamento" name="departamento" type="text"
                                value="{{ old('departamento', $address->departamento) }}" class="block mt-1 w-full" />
                        </div>
                        <div class="mt-4">
                            <label for="notas">Notas (Opcional)</label>
                            <textarea id="notas" name="notas" rows="3" class="block mt-1 w-full">{{ old('notas', $address->notas) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('clients.show', $client) }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Dirección
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
