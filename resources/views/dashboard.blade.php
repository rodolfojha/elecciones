<x-layouts.app title="Dashboard">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard - {{ auth()->user()->isAdmin() ? 'Administrador' : 'Operador' }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Bienvenido, {{ auth()->user()->name }}</p>
            </div>

            @if(auth()->user()->isAdmin())
                <!-- Estadísticas principales - Admin -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <x-card
                        title="Total Usuarios"
                        :value="$stats['total_users']"
                        subtitle="Usuarios registrados"
                        color="purple"
                        icon="fa-solid fa-users"
                    />

                    <x-card
                        title="Operadores Activos"
                        :value="$stats['total_operators']"
                        subtitle="Activos en el sistema"
                        color="blue"
                        icon="fa-solid fa-user-headset"
                    />

                    <x-card
                        title="Llamadas Hoy"
                        :value="$stats['calls_today']"
                        subtitle="Total del día"
                        color="green"
                        icon="fa-solid fa-phone"
                    />

                    <x-card
                        title="Clientes Esperando"
                        :value="$stats['available_clients']"
                        subtitle="Disponibles ahora"
                        color="amber"
                        icon="fa-solid fa-clock"
                    />
                </div>
            @else
                <!-- Estadísticas principales - Operador -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <x-card
                        title="Mis Llamadas Hoy"
                        :value="$stats['my_calls_today']"
                        subtitle="Llamadas realizadas"
                        color="blue"
                        icon="fa-solid fa-phone"
                    />

                    <x-card
                        title="Mis Clientes Activos"
                        :value="$stats['my_clients']"
                        subtitle="En proceso"
                        color="amber"
                        icon="fa-solid fa-users"
                    />

                    <x-card
                        title="Llamadas Completadas"
                        :value="$stats['completed_calls']"
                        subtitle="Total completadas"
                        color="green"
                        icon="fa-solid fa-check-circle"
                    />

                    <x-card
                        title="Total Atendidos"
                        :value="$stats['total_assigned']"
                        subtitle="Todos los clientes"
                        color="purple"
                        icon="fa-solid fa-address-book"
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
                                    <a href="{{ route('users.index') }}" class="w-full flex items-center justify-between p-4 bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white rounded-lg transition-colors">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-users mr-3"></i>
                                            <span>Gestionar Usuarios</span>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Estadísticas Generales</h3>
                                </div>
                            </div>
                    
                            <!-- Descripción -->
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-5">Resumen del sistema</p>
                    
                            <!-- Lista de estadísticas -->
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                    <span class="text-sm text-gray-900 dark:text-white">• Clientes en Espera</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $stats['available_clients'] }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                    <span class="text-sm text-gray-900 dark:text-white">• Llamadas Totales</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $stats['total_clients'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Panel de Operador</h3>
                                </div>
                            </div>
                    
                            <!-- Contenido principal -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-5">Gestiona tus llamadas y clientes</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <a href="{{ route('clients.index') }}" class="flex flex-col items-center justify-center p-6 bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white rounded-lg transition-colors">
                                        <i class="fa-solid fa-phone text-2xl mb-2"></i>
                                        <span class="font-medium">Nueva Llamada</span>
                                    </a>
                                    
                                    <a href="{{ route('history.index', ['filter' => 'active']) }}" class="flex flex-col items-center justify-center p-6 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800/50 dark:hover:bg-gray-800 text-gray-900 dark:text-white rounded-lg transition-colors border border-gray-200 dark:border-gray-700">
                                        <i class="fa-solid fa-users text-2xl mb-2"></i>
                                        <span class="font-medium">Mis Clientes</span>
                                    </a>
                                    
                                    <a href="{{ route('history.index') }}" class="flex flex-col items-center justify-center p-6 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800/50 dark:hover:bg-gray-800 text-gray-900 dark:text-white rounded-lg transition-colors border border-gray-200 dark:border-gray-700">
                                        <i class="fa-solid fa-clock text-2xl mb-2"></i>
                                        <span class="font-medium">Historial</span>
                                    </a>
                                </div>
                            </div>
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
