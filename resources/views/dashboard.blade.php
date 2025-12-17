<x-layouts.app title="Dashboard">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard - {{ auth()->user()->isAdmin() ? 'Administrador' : 'Operador' }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Bienvenido, {{ auth()->user()->name }}</p>
            </div>

            @if(auth()->user()->isAdmin())
                <!-- Estadísticas principales - Admin -->
                <!-- Estadísticas principales - Admin -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <x-card
                        title="Usuarios Añadidos"
                        :value="$stats['total_voters']"
                        subtitle="Total en el sistema"
                        color="purple"
                        icon="fa-solid fa-users"
                    />

                    <x-card
                        title="Añadidos Hoy"
                        :value="$stats['voters_today']"
                        subtitle="Registrados el día de hoy"
                        color="green"
                        icon="fa-solid fa-user-plus"
                    />
                </div>
            @else
                <!-- Estadísticas principales - Operador -->
                <!-- Estadísticas principales - Operador -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <x-card
                        title="Mis Registros"
                        :value="$stats['my_total_voters']"
                        subtitle="Total registrados por mí"
                        color="blue"
                        icon="fa-solid fa-users"
                    />

                    <x-card
                        title="Registros Hoy"
                        :value="$stats['my_voters_today']"
                        subtitle="Registrados hoy por mí"
                        color="green"
                        icon="fa-solid fa-user-plus"
                    />
                </div>
            @endif

            @if(auth()->user()->isAdmin())
                <!-- Panel de Administración -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:p-6">
                            <!-- Header con icono y título -->
                            <div class="flex justify-between items-start mb-1">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Panel de Administración</h3>
                                </div>
                            </div>
                    
                            <!-- Contenido principal -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-5">Gestiona el sistema y usuarios</p>
                                
                                <div class="space-y-3">
                                    <a href="{{ route('voters.create') }}" class="w-full flex items-center justify-between p-4 bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white rounded-lg transition-colors">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-user-plus mr-3"></i>
                                            <span>Registrar Nueva Persona</span>
                                        </div>
                                        <i class="fa-solid fa-arrow-right text-sm"></i>
                                    </a>
                                    
                                    <a href="{{ route('settings.index') }}" class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800/50 dark:hover:bg-gray-800 text-gray-900 dark:text-white rounded-lg transition-colors border border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-cog mr-3"></i>
                                            <span>Configuración</span>
                                        </div>
                                        <i class="fa-solid fa-arrow-right text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:p-6">
                            <!-- Header con icono y título -->
                            <div class="flex justify-between items-start mb-1">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                     </svg>
                                     <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mapa de Votación</h3>
                                 </div>
                            </div>
                    
                            <!-- Descripción -->
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-5">Visualiza la distribución geográfica</p>
                    
                            <a href="{{ route('voters.map') }}" class="w-full flex items-center justify-between p-4 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-map-marked-alt mr-3"></i>
                                    <span>Ver Mapa Interactivo</span>
                                </div>
                                <i class="fa-solid fa-arrow-right text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Panel de Operador -->
                <div class="mb-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:p-6">
                            <!-- Header con icono y título -->
                            <div class="flex justify-between items-start mb-1">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Acciones Rápidas</h3>
                                </div>
                            </div>
                    
                            <!-- Descripción -->
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-5">Accesos directos</p>
                    
                            <a href="{{ route('voters.create') }}" class="w-full flex items-center justify-between p-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-user-plus mr-3"></i>
                                    <span>Registrar Nueva Persona</span>
                                </div>
                                <i class="fa-solid fa-arrow-right text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- <!-- Actividad Reciente -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Actividad Reciente</h3>
                        </div>
                    </div>

                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400"></i>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm">
                                                    <span class="font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 ml-2">
                                                        Configuración
                                                    </span>
                                                </div>
                                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                                    Sistema de login configurado correctamente
                                                </p>
                                            </div>
                                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                Hace unos momentos
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                <i class="fa-solid fa-users text-blue-600 dark:text-blue-400"></i>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm">
                                                    <span class="font-medium text-gray-900 dark:text-white">Sistema</span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 ml-2">
                                                        Usuarios
                                                    </span>
                                                </div>
                                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                                    Usuarios de prueba creados exitosamente
                                                </p>
                                            </div>
                                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                Hace unos momentos
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                <i class="fa-solid fa-shield-halved text-purple-600 dark:text-purple-400"></i>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm">
                                                    <span class="font-medium text-gray-900 dark:text-white">Sistema</span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 ml-2">
                                                        Seguridad
                                                    </span>
                                                </div>
                                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                                    Roles y permisos configurados correctamente
                                                </p>
                                            </div>
                                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                Hace unos momentos
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</x-layouts.app>
