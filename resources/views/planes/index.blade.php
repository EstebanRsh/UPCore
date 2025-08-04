<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Planes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('planes.create') }}"
                            class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded">
                            Crear Nuevo Plan
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">ID</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Nombre del Plan</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Velocidad (Mbps)</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Precio Mensual</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($planes as $plan)
                                    <tr>
                                        <td class="py-3 px-4">{{ $plan->id }}</td>
                                        <td class="py-3 px-4">{{ $plan->nombre_plan }}</td>
                                        <td class="py-3 px-4">{{ $plan->velocidad_mbps }}</td>
                                        <td class="py-3 px-4">${{ number_format($plan->precio_mensual, 2) }}</td>
                                        <td class="py-3 px-4">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
