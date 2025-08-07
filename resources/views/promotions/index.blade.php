<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Promociones
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('promotions.create') }}"
                            class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded">
                            Crear Nueva Promoción
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Nombre</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Duración</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Descuento</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Estado</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($promotions as $promo)
                                <tr>
                                    <td class="py-3 px-4">{{ $promo->nombre }}</td>
                                    <td class="py-3 px-4">{{ $promo->duracion_meses }} meses</td>
                                    <td class="py-3 px-4">{{ $promo->valor_descuento }} ({{ $promo->tipo_descuento }})
                                    </td>
                                    <td class="py-3 px-4">{{ $promo->activa ? 'Activa' : 'Inactiva' }}</td>

                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('promotions.edit', $promo) }}"
                                                class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                Editar
                                            </a>
                                            <form action="{{ route('promotions.destroy', $promo) }}" method="POST"
                                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta promoción?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-800 text-white font-bold py-1 px-3 rounded text-xs">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-3 px-4 text-center">No hay promociones creadas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
