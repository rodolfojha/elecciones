<div wire:poll.5s>
    <!-- Estadísticas Generales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-card
            title="Total Operadores"
            :value="$stats['total_operators']"
            subtitle="En el sistema"
            color="purple"
            icon="fa-solid fa-users"
        />
        
        <x-card
            title="Operadores Activos"
            :value="$stats['active_operators']"
            subtitle="Atendiendo clientes"
            color="green"
            icon="fa-solid fa-user-check"
        />
        
        <x-card
            title="Clientes en Espera"
            :value="$stats['clients_in_queue']"
            subtitle="Sin asignar"
            color="amber"
            icon="fa-solid fa-clock"
        />

        <x-card
            title="Clientes en Atención"
            :value="$stats['clients_being_attended']"
            subtitle="Siendo atendidos"
            color="blue"
            icon="fa-solid fa-headset"
        />
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Buscar Operador
                </label>
                <input 
                    type="text" 
                    wire:model.live="searchTerm"
                    id="search"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Nombre o email del operador..."
                >
            </div>
            <div>
                <label for="filterStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Filtrar por Estado de Cliente
                </label>
                <select 
                    wire:model.live="filterStatus"
                    id="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                >
                    <option value="">Todos los estados</option>
                    <option value="assigned">Asignados</option>
                    <option value="contacted">Contactados</option>
                    <option value="completed">Completados</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Lista de Operadores y sus Clientes -->
    <div class="space-y-6">
        @forelse($operators as $operator)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Header del Operador -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 rounded-full bg-white flex items-center justify-center text-blue-600 font-bold text-xl shadow-lg">
                                {{ $operator->initials() }}
                            </div>
                            <div class="text-white">
                                <h3 class="text-xl font-bold">{{ $operator->name }}</h3>
                                <p class="text-blue-100 text-sm">{{ $operator->email }}</p>
                                <div class="flex items-center space-x-3 mt-1">
                                    <span class="inline-flex items-center text-xs">
                                        <i class="fa-solid fa-users mr-1"></i>
                                        {{ $operator->total_clients }} total
                                    </span>
                                    <span class="inline-flex items-center text-xs">
                                        <i class="fa-solid fa-clock mr-1"></i>
                                        {{ $operator->active_clients }} activos
                                    </span>
                                    <span class="inline-flex items-center text-xs">
                                        <i class="fa-solid fa-check-circle mr-1"></i>
                                        {{ $operator->completed_today }} hoy
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Estado del Operador -->
                        <div>
                            @if($operator->active_clients > 0)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800 shadow">
                                    <span class="h-2 w-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800 shadow">
                                    <span class="h-2 w-2 rounded-full bg-gray-500 mr-2"></span>
                                    Libre
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Clientes del Operador -->
                <div class="p-6">
                    @if($operator->clients->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($operator->clients as $client)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow bg-gray-50 dark:bg-gray-900/50">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                                {{ $client->full_name }}
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center mt-1">
                                                <i class="fa-solid fa-phone mr-2"></i>
                                                {{ $client->phone }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $client->status === 'assigned' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                            {{ $client->status === 'contacted' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                            {{ $client->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                        ">
                                            {{ ucfirst($client->status) }}
                                        </span>
                                    </div>

                                    @if($client->email)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 flex items-center">
                                            <i class="fa-solid fa-envelope mr-2"></i>
                                            {{ $client->email }}
                                        </p>
                                    @endif

                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <div>
                                            <i class="fa-solid fa-clock mr-1"></i>
                                            Asignado {{ $client->assigned_at?->diffForHumans() }}
                                        </div>
                                        <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium">
                                            Ver detalles →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fa-solid fa-inbox text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500 dark:text-gray-400">
                                Este operador no tiene clientes {{ $filterStatus ? 'con ese estado' : 'asignados' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-12">
                <div class="text-center">
                    <i class="fa-solid fa-search text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No se encontraron operadores</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ $searchTerm ? 'Intenta con otro término de búsqueda' : 'No hay operadores registrados en el sistema' }}
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Indicador de actualización automática -->
    <div class="mt-6 text-center">
        <div class="inline-flex items-center px-4 py-2 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-full text-sm text-blue-700 dark:text-blue-300">
            <span class="h-2 w-2 rounded-full bg-blue-500 mr-2 animate-pulse"></span>
            Actualizándose automáticamente cada 5 segundos
        </div>
    </div>
</div>
