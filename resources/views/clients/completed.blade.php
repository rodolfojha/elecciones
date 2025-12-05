<x-layouts.app title="Clientes Completados">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fa-solid fa-check-circle mr-2 text-green-600"></i>
                    Clientes Completados
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    @if(auth()->user()->isAdmin())
                        Historial de clientes con gestión finalizada y notas del operador
                    @else
                        Tus clientes con gestión finalizada
                    @endif
                </p>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-card
                    title="Total Completados"
                    :value="$stats['total']"
                    subtitle="Clientes finalizados"
                    color="green"
                    icon="fa-solid fa-check-circle"
                />
                
                <x-card
                    title="Hoy"
                    :value="$stats['today']"
                    subtitle="Completados hoy"
                    color="blue"
                    icon="fa-solid fa-calendar-day"
                />
                
                <x-card
                    title="Esta Semana"
                    :value="$stats['this_week']"
                    subtitle="Completados esta semana"
                    color="purple"
                    icon="fa-solid fa-calendar-week"
                />
            </div>

            <!-- Lista de Clientes Completados -->
            @if($clients->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Cliente
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Contacto
                                    </th>
                                    @if(auth()->user()->isAdmin())
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Operador
                                        </th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Notas
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Completado
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($clients as $client)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <!-- Cliente -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-semibold">
                                                        {{ substr($client->first_name, 0, 1) }}{{ substr($client->last_name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $client->full_name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        ID: #{{ $client->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Contacto -->
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                <div class="flex items-center">
                                                    <i class="fa-solid fa-phone mr-2 text-gray-400"></i>
                                                    {{ $client->phone }}
                                                </div>
                                            </div>
                                        </td>

                                        @if(auth()->user()->isAdmin())
                                            <!-- Operador -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-xs mr-2">
                                                        {{ $client->assignedTo->initials() }}
                                                    </div>
                                                    <div class="text-sm">
                                                        <div class="font-medium text-gray-900 dark:text-white">
                                                            {{ $client->assignedTo->name }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $client->assigned_at->format('d/m/Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif

                                        <!-- Notas (Preview) -->
                                        <td class="px-6 py-4 max-w-xs">
                                            @if($client->notes)
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    <p class="line-clamp-2">{{ $client->notes }}</p>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400 italic">Sin notas</span>
                                            @endif
                                        </td>

                                        <!-- Fecha de Completado -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ $client->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $client->updated_at->diffForHumans() }}
                                            </div>
                                        </td>

                                        <!-- Acciones -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @php
                                                $clientData = $client->toArray();
                                                $clientData['course'] = $client->course ? $client->course->toArray() : null;
                                                $clientData['assigned_to'] = $client->assignedTo ? ['name' => $client->assignedTo->name] : null;
                                            @endphp
                                            <button 
                                                onclick="openClientModal(@js($clientData))"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors"
                                            >
                                                <i class="fa-solid fa-eye mr-1"></i>
                                                Ver Detalles
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $clients->links() }}
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-12">
                    <div class="text-center">
                        <i class="fa-solid fa-inbox text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay clientes completados</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Los clientes completados aparecerán aquí
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para ver detalles completos -->
    <div id="clientModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <!-- Modal content -->
            <div class="mt-3">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white" id="modalClientName">
                        
                    </h3>
                    <button onclick="closeClientModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i class="fa-solid fa-times text-2xl"></i>
                    </button>
                </div>

                <!-- Content -->
                <div class="space-y-6" id="modalContent">
                    <!-- Content will be populated by JavaScript -->
                </div>

                <!-- Footer -->
                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button 
                        onclick="closeClientModal()" 
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition-colors"
                    >
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openClientModal(client) {
            const modal = document.getElementById('clientModal');
            const modalName = document.getElementById('modalClientName');
            const modalContent = document.getElementById('modalContent');

            // Set client name
            modalName.textContent = client.first_name + ' ' + client.last_name;

            // Build content
            let content = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información Personal -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wide">
                            <i class="fa-solid fa-user mr-2"></i>Información Personal
                        </h4>
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Nombre Completo</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">${client.first_name} ${client.last_name}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Teléfono</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">${client.phone}</p>
                            </div>
                            ${client.email ? `
                                <div>
                                    <label class="text-xs text-gray-500 dark:text-gray-400">Email</label>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">${client.email}</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>

                    <!-- Información de Gestión -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wide">
                            <i class="fa-solid fa-headset mr-2"></i>Información de Gestión
                        </h4>
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Operador</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">${client.assigned_to?.name || 'N/A'}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Fecha de Asignación</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">${client.assigned_at ? new Date(client.assigned_at).toLocaleString('es-ES') : 'N/A'}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Completado</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">${new Date(client.updated_at).toLocaleString('es-ES')}</p>
                            </div>
                            ${client.course ? `
                                <div>
                                    <label class="text-xs text-gray-500 dark:text-gray-400">Curso Asignado</label>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        <i class="fa-solid fa-graduation-cap mr-1 text-blue-500"></i>
                                        ${client.course.title}
                                    </p>
                                </div>
                            ` : `
                                <div>
                                    <label class="text-xs text-gray-500 dark:text-gray-400">Curso Asignado</label>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 italic">No asignado</p>
                                </div>
                            `}
                        </div>
                    </div>
                </div>

                <!-- Notas del Operador -->
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-3 uppercase tracking-wide">
                        <i class="fa-solid fa-note-sticky mr-2"></i>Notas del Operador
                    </h4>
                    ${client.notes ? `
                        <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">${client.notes}</p>
                    ` : `
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">No se agregaron notas para este cliente</p>
                    `}
                </div>
            `;

            modalContent.innerHTML = content;
            modal.classList.remove('hidden');
        }

        function closeClientModal() {
            const modal = document.getElementById('clientModal');
            modal.classList.add('hidden');
        }

        // Close modal on outside click
        document.getElementById('clientModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeClientModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeClientModal();
            }
        });
    </script>
    @endpush
</x-layouts.app>

