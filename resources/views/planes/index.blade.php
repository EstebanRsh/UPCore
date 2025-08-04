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

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">¡Éxito!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

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
                                            <a href="{{ route('planes.edit', $plan) }}"
                                                class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                Editar
                                            </a>
                                            <form action="{{ route('planes.destroy', $plan) }}" method="POST"
                                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este plan?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-800 text-white font-bold py-1 px-3 rounded text-xs">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
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
