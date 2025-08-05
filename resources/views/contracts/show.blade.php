<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles del Contrato #{{ $contract->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Estado del Contrato</h3>
                            @php
                                $color = '';
                                if ($contract->estado === 'Activo') {
                                    $color = 'bg-green-200 text-green-800';
                                } elseif ($contract->estado === 'Suspendido') {
                                    $color = 'bg-yellow-200 text-yellow-800';
                                } elseif ($contract->estado === 'Cancelado') {
                                    $color = 'bg-red-200 text-red-800';
                                }
                            @endphp
                            <span class="px-3 py-1 font-semibold leading-tight rounded-full text-sm {{ $color }}">
                                {{ $contract->estado }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">Fecha de Instalación:
                            {{ \Carbon\Carbon::parse($contract->fecha_instalacion)->format('d/m/Y') }}</p>

                        <div class="flex items-center space-x-2 mt-4">
                            @if ($contract->estado === 'Activo')
                                <form action="{{ route('contracts.updateStatus', $contract) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estado" value="Suspendido">
                                    <button type="submit"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                                        Suspender
                                    </button>
                                </form>
                            @elseif ($contract->estado === 'Suspendido')
                                <form action="{{ route('contracts.updateStatus', $contract) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estado" value="Activo">
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                        Reactivar
                                    </button>
                                </form>
                            @endif

                            @if ($contract->estado !== 'Cancelado')
                                <form action="{{ route('contracts.updateStatus', $contract) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que quieres cancelar este contrato? Esta acción es permanente.');">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estado" value="Cancelado">
                                    <button type="submit"
                                        class="bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                                        Cancelar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium">Historial de Facturación</h3>
                        <p class="mt-4 text-gray-500">Próximamente: Aquí se mostrará la lista de facturas y pagos
                            asociados a este contrato.</p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-1 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-2">Cliente</h3>
                        <p><strong>{{ $contract->client->nombre }} {{ $contract->client->apellido }}</strong></p>
                        <p class="text-sm text-gray-600">{{ $contract->client->user->email }}</p>
                        <p class="text-sm text-gray-600">DNI/CUIT: {{ $contract->client->dni_cuit }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-2">Plan Contratado</h3>
                        <p><strong>{{ $contract->plan->nombre_plan }}</strong></p>
                        <p class="text-sm text-gray-600">{{ $contract->plan->velocidad_mbps }} Mbps</p>
                        <p class="text-sm text-gray-600">${{ number_format($contract->plan->precio_mensual, 2) }} / mes
                        </p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-2">Dirección del Servicio</h3>
                        <p><strong>{{ $contract->serviceAddress->etiqueta }}</strong></p>
                        <p class="text-sm text-gray-600">{{ $contract->serviceAddress->direccion }}</p>
                        <p class="text-sm text-gray-600">{{ $contract->serviceAddress->ciudad }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
