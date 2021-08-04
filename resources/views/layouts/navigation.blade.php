<nav x-data="{ open: false }" class="navbar-light bg-light nav-navigation">
    @auth
        <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('index')" :active="request()->routeIs('index')">
                        {{ __('Página inicial') }}
                    </x-nav-link>
                    @can('ver-etapa')
                    <x-nav-link :href="route('etapas.index')" :active="request()->routeIs('etapas.*')">
                        {{ __('Públicos') }}
                    </x-nav-link>
                    @endcan
                    @can('ver-lote')
                    <x-nav-link :href="route('lotes.index')" :active="request()->routeIs('lotes.*')">
                        {{ __('Lotes') }}
                    </x-nav-link>
                    @endcan
                    @can('ver-posto')
                        <x-nav-link :href="route('postos.index.new')" :active="request()->routeIs('postos.*')">
                            {{ __('Pontos') }}
                        </x-nav-link>
                    @endcan
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Agendamentos') }}
                    </x-nav-link>
                    {{-- <x-responsive-nav-link :href="route('dashboard.novo')" :active="request()->routeIs('dashboard.*')">
                        {{ __('Agendamentos 2') }}
                    </x-responsive-nav-link> --}}
                    @can('ver-estatistica')
                    <x-nav-link :href="route('estatistica.index')" :active="request()->routeIs('estatistica.*')">
                        {{ __('Estatísticas') }}
                    </x-nav-link>
                    @endcan
                    @can('ver-estatistica-ponto')
                    <x-nav-link :href="route('estatistica.showStats')" :active="request()->routeIs('estatistica.*')">
                        {{ __('Estatísticas Ponto') }}
                    </x-nav-link>
                    @endcan
                    @can('ver-export')
                    <x-nav-link :href="route('export.index')" :active="request()->routeIs('export.*')">
                        {{ __('Exportar/Importar') }}
                    </x-nav-link>
                    @endcan
                    @can('horarios')
                    <x-nav-link :href="route('horarios.index')" :active="request()->routeIs('horarios.*')">
                        {{ __('Horários') }}
                    </x-nav-link>
                    @endcan
                    @can('ver-config')
                    <x-nav-link :href="route('config.index')" :active="request()->routeIs('config.*')">
                        {{ __('Configurações') }}
                    </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        @can('criar-user')
                            <x-dropdown-link :href="route('admin.form.user')">
                                {{ __('Criar usuário') }}
                            </x-dropdown-link>
                        @endcan
                        @can('criar-user')
                            <x-dropdown-link :href="route('admin.list.user')">
                                {{ __('Editar usuários') }}
                            </x-dropdown-link>
                        @endcan
                        @can('posicao-fila')
                            <x-dropdown-link :href="route('admin.posicao.fila')">
                                {{ __('Posição fila') }}
                            </x-dropdown-link>
                        @endcan
                        @can('reagendar-data')
                            <x-dropdown-link :href="route('admin.editar.lista.data')">
                                {{ __('Editar data') }}
                            </x-dropdown-link>
                        @endcan
                        @can('reagendar-data')
                            <x-dropdown-link :href="route('admin.arquivados.index')">
                                {{ __('Arquivados') }}
                            </x-dropdown-link>
                        @endcan

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </form>

                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('index')" :active="request()->routeIs('index')">
                {{ __('Página inicial') }}
            </x-responsive-nav-link>
            @can('ver-etapa')
            <x-responsive-nav-link :href="route('etapas.index')" :active="request()->routeIs('etapas.*')">
                {{ __('Públicos') }}
            </x-responsive-nav-link>
            @endif
            @can('ver-lote')
            <x-responsive-nav-link :href="route('lotes.index')" :active="request()->routeIs('lotes.*')">
                {{ __('Lotes') }}
            </x-responsive-nav-link>
            @endif
            @can('ver-posto')
            <x-responsive-nav-link :href="route('postos.index.new')" :active="request()->routeIs('postos.*')">
                {{ __('Pontos') }}
            </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Agendamentos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('fila.index')" :active="request()->routeIs('fila.*')">
                {{ __('Fila de Espera') }}
            </x-responsive-nav-link>
            @can('horarios')
            <x-responsive-nav-link :href="route('horarios.index')" :active="request()->routeIs('horarios.*')">
                {{ __('Horários') }}
            </x-responsive-nav-link>
            @endcan
            @can('ver-export')
            <x-responsive-nav-link :href="route('export.index')" :active="request()->routeIs('export.*')">
                {{ __('Exportar/Importar') }}
            </x-responsive-nav-link>
            @endcan
            <x-responsive-nav-link :href="route('config.index')" :active="request()->routeIs('config.*')">
                {{ __('Configurações') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                @can('posicao-fila')
                    <x-dropdown-link :href="route('admin.posicao.fila')">
                        {{ __('Posição fila') }}
                    </x-dropdown-link>
                @endcan
                @can('reagendar-data')
                    <x-dropdown-link :href="route('admin.editar.lista.data')">
                        {{ __('Editar data') }}
                    </x-dropdown-link>
                @endcan
                @can('reagendar-data')
                    <x-dropdown-link :href="route('admin.editar.lista.data')">
                        {{ __('Arquivados') }}
                    </x-dropdown-link>
                @endcan

                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    @endauth
</nav>
