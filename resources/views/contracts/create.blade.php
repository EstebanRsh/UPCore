<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Contrato para: {{ $client->nombre }} {{ $client->apellido }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('contracts.store', $client) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="plan_id" class="block font-medium text-sm text-gray-700">Plan de
                                    Servicio</label>
                                <select name="plan_id" id="plan_id"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                    <option value="">-- Seleccione un Plan --</option>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->nombre_plan }}
                                            ({{ $plan->velocidad_mbps }} Mbps)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="service_address_id"
                                    class="block font-medium text-sm text-gray-700">Dirección de Instalación</label>
                                <select name="service_address_id" id="service_address_id"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                    <option value="">-- Seleccione una Dirección --</option>
                                    @foreach ($addresses as $address)
                                        <option value="{{ $address->id }}">{{ $address->etiqueta }} -
                                            {{ $address->direccion }}, {{ $address->ciudad }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="fecha_instalacion" class="block font-medium text-sm text-gray-700">Fecha de
                                    Instalación</label>
                                <input type="date" name="fecha_instalacion" id="fecha_instalacion"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            </div>

                            <div>
                                <label for="estado" class="block font-medium text-sm text-gray-700">Estado
                                    Inicial</label>
                                <select name="estado" id="estado"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                    <option value="Activo">Activo</option>
                                    <option value="Suspendido">Suspendido</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('clients.show', $client) }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Contrato
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
