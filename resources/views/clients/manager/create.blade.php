<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('clients.store') }}">
                        @csrf

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Datos Personales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" value="Nombre" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="apellido" value="Apellido" />
                                <x-text-input id="apellido" class="block mt-1 w-full" type="text" name="apellido" :value="old('apellido')" required />
                                <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="dni_cuit" value="DNI o CUIT" />
                                <x-text-input id="dni_cuit" class="block mt-1 w-full" type="text" name="dni_cuit" :value="old('dni_cuit')" required />
                                <x-input-error :messages="$errors->get('dni_cuit')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="telefono" value="Teléfono (Opcional)" />
                                <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" />
                                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="my-8">

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Datos de Acceso al Sistema</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="email" value="Correo Electrónico" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                             <div>
                                <x-input-label for="password" value="Contraseña" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" value="Confirmar Contraseña" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('clients.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">
                                Cancelar
                            </a>
                            <x-primary-button>
                                Guardar Cliente
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>