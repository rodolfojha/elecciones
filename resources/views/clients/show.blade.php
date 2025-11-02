<x-layouts.app title="Detalle del Cliente">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $client->full_name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">Información del cliente</p>
                </div>
                <a href="{{ route('clients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Volver a la Lista
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                    <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Información del Cliente -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center mb-6">
                                <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-2xl">
                                    {{ substr($client->first_name, 0, 1) }}{{ substr($client->last_name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $client->full_name }}</h2>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $client->status === 'waiting' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' : '' }}
                                        {{ $client->status === 'assigned' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                        {{ $client->status === 'contacted' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                        {{ $client->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                    ">
                                        {{ ucfirst($client->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Información de Contacto</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                <i class="fa-solid fa-phone mr-2 text-gray-400"></i>Teléfono
                                            </label>
                                            <p class="text-lg text-gray-900 dark:text-white">{{ $client->phone }}</p>
                                        </div>
                                        @if($client->email)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                    <i class="fa-solid fa-envelope mr-2 text-gray-400"></i>Email
                                                </label>
                                                <p class="text-lg text-gray-900 dark:text-white">{{ $client->email }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if($client->address || $client->city || $client->state)
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">
                                            <i class="fa-solid fa-location-dot mr-2"></i>Dirección
                                        </h3>
                                        @if($client->address)
                                            <p class="text-gray-900 dark:text-white">{{ $client->address }}</p>
                                        @endif
                                        @if($client->city || $client->state)
                                            <p class="text-gray-900 dark:text-white">{{ $client->city }}{{ $client->city && $client->state ? ', ' : '' }}{{ $client->state }}</p>
                                        @endif
                                    </div>
                                @endif

                                @if($client->notes)
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">
                                            <i class="fa-solid fa-note-sticky mr-2"></i>Notas
                                        </h3>
                                        <p class="text-gray-900 dark:text-white whitespace-pre-line">{{ $client->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones y Estado -->
                <div class="space-y-6">
                    <!-- Información de Asignación -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información de Asignación</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Asignado a</label>
                                    <p class="text-gray-900 dark:text-white font-medium">{{ $client->assignedTo->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de asignación</label>
                                    <p class="text-gray-900 dark:text-white">{{ $client->assigned_at->format('d/m/Y H:i') }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $client->assigned_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actualizar Estado -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actualizar Estado</h3>
                            <form action="{{ route('clients.update-status', $client) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado</label>
                                    <select id="status" name="status" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="assigned" {{ $client->status === 'assigned' ? 'selected' : '' }}>Asignado</option>
                                        <option value="contacted" {{ $client->status === 'contacted' ? 'selected' : '' }}>Contactado</option>
                                        <option value="completed" {{ $client->status === 'completed' ? 'selected' : '' }}>Completado</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notas adicionales</label>
                                    <textarea id="notes" name="notes" rows="3" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Agrega notas sobre la llamada...">{{ old('notes', $client->notes) }}</textarea>
                                </div>

                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                    <i class="fa-solid fa-save mr-2"></i>
                                    Guardar Cambios
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones Rápidas</h3>
                            <div class="space-y-2">
                                <a href="tel:{{ $client->phone }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors">
                                    <i class="fa-solid fa-phone mr-2"></i>
                                    Llamar Ahora
                                </a>
                                @if($client->email)
                                    <a href="mailto:{{ $client->email }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white text-sm font-medium rounded-md transition-colors">
                                        <i class="fa-solid fa-envelope mr-2"></i>
                                        Enviar Email
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

