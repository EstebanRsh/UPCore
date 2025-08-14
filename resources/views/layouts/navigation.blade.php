<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">

                    @if (Auth::user()->rol === 'manager')
                        {{-- Dashboard --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Dashboard
                        </x-nav-link>

                        {{-- Clientes --}}
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('clients.*') || request()->routeIs('approvals.*') ? 'border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300' }}">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-3-5.197M15 21a9 9 0 00-3-5.197M15 12a5.995 5.995 0 00-3-5.197M12 12.75a5.995 5.995 0 00-3 5.197">
                                            </path>
                                        </svg>
                                        <div>Clientes</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('clients.index')">Listado de Clientes</x-dropdown-link>
                                    <x-dropdown-link :href="route('approvals.index')">Aprobaciones</x-dropdown-link>
                                    <x-dropdown-link :href="route('clients.create')">Nuevo Cliente</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        {{-- Facturación --}}
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('billing.*') ? 'border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <div>Facturación</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('billing.index')">Realizar Cobro</x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-gray-400 cursor-not-allowed">Historial
                                        de Pagos</x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-gray-400 cursor-not-allowed">Facturas
                                        Pendientes</x-dropdown-link>
                                    <div class="border-t border-gray-200"></div>
                                    <x-dropdown-link href="#" class="text-gray-400 cursor-not-allowed">Reportes
                                        (Próximamente)</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        {{-- Configuraciones (NUEVO) --}}
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('planes.*') || request()->routeIs('settings.*') ? 'border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 3a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v1.036a7.5 7.5 0 012.313 1.337l.733-.423a.75.75 0 011.024.274l1.5 2.598a.75.75 0 01-.274 1.024l-.733.423c.108.49.163.997.163 1.511s-.055 1.02-.163 1.51l.733.424a.75.75 0 01.274 1.024l-1.5 2.598a.75.75 0 01-1.024.274l-.733-.423a7.5 7.5 0 01-2.313 1.337V21a.75.75 0 01-.75.75h-3A.75.75 0 0110.5 21v-1.036a7.5 7.5 0 01-2.313-1.337l-.733.423a.75.75 0 01-1.024-.274l-1.5-2.598a.75.75 0 01.274-1.024l.733-.424A7.53 7.53 0 015 12c0-.514.055-1.02.163-1.51l-.733-.423a.75.75 0 01-.274-1.024l1.5-2.598a.75.75 0 011.024-.274l.733.423A7.5 7.5 0 017.5 4.036V3z" />
                                        </svg>
                                        <div>Configuraciones</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    {{-- Planes y tarifas --}}
                                    <x-dropdown-link :href="route('settings.planes.index')" :active="request()->routeIs('settings.planes.*')">
                                        Planes y tarifas
                                    </x-dropdown-link>

                                    {{-- Placeholders de configuración extra --}}
                                    <x-dropdown-link href="#" class="text-gray-400 cursor-not-allowed">
                                        Usuarios (Próximamente)
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-gray-400 cursor-not-allowed">
                                        Roles y permisos (Próximamente)
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-gray-400 cursor-not-allowed">
                                        Preferencias del sistema (Próximamente)
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        {{-- Ayuda (placebo) --}}
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 14h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z" />
                                        </svg>
                                        <div>Ayuda</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#" class="text-gray-400 cursor-not-allowed">
                                        Manual de Usuario (Próximamente)
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-gray-400 cursor-not-allowed">
                                        Centro de soporte (Próximamente)
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-gray-400 cursor-not-allowed">
                                        Contactar al administrador (Próximamente)
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @elseif (Auth::user()->rol === 'cliente')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Mi Resumen
                        </x-nav-link>
                        <x-nav-link :href="route('client.payments.index')" :active="request()->routeIs('client.payments.index')">
                            Historial de Pagos
                        </x-nav-link>
                    @elseif (Auth::user()->rol === 'pendiente')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Bienvenido
                        </x-nav-link>
                    @endif

                </div>
            </div>

            {{-- Usuario --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Mi Perfil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar Sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburguesa --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (Auth::user()->rol === 'manager')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')">Clientes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('approvals.index')" :active="request()->routeIs('approvals.*')">Aprobaciones</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('billing.index')" :active="request()->routeIs('billing.*')">Facturación</x-responsive-nav-link>

                {{-- Configuraciones (responsive) --}}
                <div class="border-t border-gray-200 my-2"></div>
                <div class="px-4 py-2 text-xs text-gray-500">Configuraciones</div>
                <x-responsive-nav-link :href="route('settings.planes.index')" :active="request()->routeIs('settings.planes.*')">
                    Planes y tarifas
                </x-responsive-nav-link>
            @elseif(Auth::user()->rol === 'cliente')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Mi Resumen</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('client.payments.index')" :active="request()->routeIs('client.payments.index')">Historial de Pagos</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Bienvenido</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Mi Perfil</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
