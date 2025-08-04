<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Plan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('planes.store') }}">
                        @csrf

                        <div>
                            <label for="nombre_plan" class="block font-medium text-sm text-gray-700">Nombre del
                                Plan</label>
                            <input id="nombre_plan" name="nombre_plan" type="text"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="velocidad_mbps" class="block font-medium text-sm text-gray-700">Velocidad
                                (Mbps)</label>
                            <input id="velocidad_mbps" name="velocidad_mbps" type="number"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required />
                        </div>

                        <div class="mt-4">
                            <label for="precio_mensual" class="block font-medium text-sm text-gray-700">Precio Mensual
                                ($)</label>
                            <input id="precio_mensual" name="precio_mensual" type="number" step="0.01"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required />
                        </div>

                        <div class="mt-4">
                            <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción
                                (Opcional)</label>
                            <textarea id="descripcion" name="descripcion" rows="4"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
