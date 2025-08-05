<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editando Cliente: {{ $client->nombre }} {{ $client->apellido }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('clients.update', $client) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre</label>
                                <input id="nombre" name="nombre" type="text"
                                    value="{{ old('nombre', $client->nombre) }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required />
                            </div>
                            <div>
                                <label for="apellido" class="block font-medium text-sm text-gray-700">Apellido</label>
                                <input id="apellido" name="apellido" type="text"
                                    value="{{ old('apellido', $client->apellido) }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required />
                            </div>
                            <div>
                                <label for="dni_cuit" class="block font-medium text-sm text-gray-700">DNI / CUIT</label>
                                <input id="dni_cuit" name="dni_cuit" type="text"
                                    value="{{ old('dni_cuit', $client->dni_cuit) }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" />
                            </div>
                            <div>
                                <label for="telefono" class="block font-medium text-sm text-gray-700">Teléfono</label>
                                <input id="telefono" name="telefono" type="text"
                                    value="{{ old('telefono', $client->telefono) }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('clients.show', $client) }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Cliente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
