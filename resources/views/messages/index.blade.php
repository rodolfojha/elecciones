<x-layouts.app title="Mensajes">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Mensajes</h1>
                <p class="text-gray-600 dark:text-gray-400">Selecciona clientes completados y envía un mensaje</p>
            </div>

            <!-- Mensaje de estado global -->
            <div id="globalStatusMessage" class="mb-4 hidden"></div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Panel izquierdo: Área de escritura -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 flex flex-col" style="min-height: 600px;">
                    <!-- Header -->
                    <div class="bg-green-500 text-white p-4 rounded-t-lg">
                        <h2 class="text-lg font-semibold">Nuevo Mensaje</h2>
                        <p class="text-sm text-green-100" id="selectedCount">
                            0 usuario(s) seleccionado(s)
                        </p>
                    </div>

                    <!-- Área de escritura - Arriba -->
                    <div class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                        <form id="messageForm">
                            @csrf
                            
                            <!-- Input de mensaje -->
                            <div class="mb-4">
                                <label for="messageContent" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Mensaje
                                </label>
                                <textarea 
                                    name="content" 
                                    id="messageContent"
                                    rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white resize-none"
                                    placeholder="Escribe tu mensaje aquí..."
                                    style="min-height: 120px;"
                                ></textarea>
                                <div class="mt-2 flex items-center justify-between text-sm text-gray-500">
                                    <span id="charCount">0 caracteres</span>
                                    <span class="text-gray-400">Mínimo 10 caracteres</span>
                                </div>
                            </div>

                            <!-- Campo de frecuencia -->
                            <div class="mb-6">
                                <label for="frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Frecuencia de envío (segundos entre cada mensaje)
                                </label>
                                <input 
                                    type="number" 
                                    name="frequency" 
                                    id="frequency"
                                    min="60"
                                    value="60"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Ej: 60"
                                    required
                                >
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Tiempo mínimo: 60 segundos entre cada mensaje
                                </p>
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex justify-center space-x-4">
                                <button 
                                    type="button"
                                    id="saveButton"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors font-medium flex items-center space-x-2"
                                >
                                    <i class="fas fa-save"></i>
                                    <span>Guardar Configuración</span>
                                </button>
                                
                                <button 
                                    type="button"
                                    id="sendButton"
                                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg transition-colors font-medium flex items-center space-x-2"
                                >
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Enviar Mensajes</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Panel de progreso (oculto inicialmente) -->
                    <div id="progressPanel" class="hidden border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Envío de Mensajes en Progreso</h3>
                            
                            <!-- Información del proceso -->
                            <div id="processInfo" class="mb-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-medium">PID:</span>
                                    <span id="processPid" class="text-gray-600 dark:text-gray-300">-</span>
                                </div>
                                <div class="flex justify-between items-center text-sm mt-1">
                                    <span class="font-medium">Estado:</span>
                                    <span id="processStatus" class="text-green-600 font-medium">Ejecutándose</span>
                                </div>
                            </div>
                            
                            <!-- Barra de progreso -->
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div id="progressBar" class="bg-green-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mt-1">
                                <span id="progressText">0/0 mensajes enviados</span>
                                <span id="progressPercentage">0%</span>
                            </div>
                            
                            <!-- Contadores -->
                            <div class="mt-3 grid grid-cols-2 gap-4 text-center">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900 rounded">
                                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-300" id="currentCount">0</div>
                                    <div class="text-xs text-blue-500 dark:text-blue-400">Actual</div>
                                </div>
                                <div class="p-2 bg-purple-50 dark:bg-purple-900 rounded">
                                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-300" id="maxCount">0</div>
                                    <div class="text-xs text-purple-500 dark:text-purple-400">Máximo</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de control -->
                        <div class="flex justify-center space-x-4">
                            <button 
                                id="cancelButton"
                                class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition-colors font-medium flex items-center space-x-2"
                            >
                                <i class="fas fa-stop-circle"></i>
                                <span>Cancelar Envío</span>
                            </button>
                            
                            <button 
                                id="refreshButton"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition-colors font-medium flex items-center space-x-2"
                            >
                                <i class="fas fa-sync-alt"></i>
                                <span>Actualizar</span>
                            </button>
                        </div>
                    </div>

                    <!-- Área de visualización estilo WhatsApp -->
                    <div class="flex-1 bg-gray-100 dark:bg-gray-900 p-4 overflow-y-auto">
                        <!-- Área vacía -->
                    </div>
                </div>

                <!-- Panel derecho: Lista de teléfonos -->
                <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Usuarios Registrados</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            <span id="totalCount">{{ $voters->count() }}</span> contacto(s) disponible(s)
                        </p>
                        <!-- Selector de todos/ninguno -->
                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="selectAll"
                                    class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                                >
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Seleccionar todos / Deseleccionar todos
                                </span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Lista de teléfonos con checkboxes -->
                    <div class="overflow-y-auto" style="max-height: 600px;">
                        @forelse($voters as $voter)
                            <div class="p-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <input 
                                        type="checkbox" 
                                        class="contact-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500" 
                                        value="{{ $voter->id }}"
                                        data-phone="{{ $voter->telefono }}"
                                        id="voter_{{ $voter->id }}"
                                    >
                                    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $voter->telefono }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ $voter->nombre }} {{ $voter->apellido }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2"></i>
                                <p>No hay usuarios registrados con teléfono</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Elementos del DOM
        const messageContent = document.getElementById('messageContent');
        const charCount = document.getElementById('charCount');
        const saveButton = document.getElementById('saveButton');
        const sendButton = document.getElementById('sendButton');
        const selectedCount = document.getElementById('selectedCount');
        const clientCheckboxes = document.querySelectorAll('.contact-checkbox');
        const selectAllCheckbox = document.getElementById('selectAll');
        const progressPanel = document.getElementById('progressPanel');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const progressPercentage = document.getElementById('progressPercentage');
        const currentCount = document.getElementById('currentCount');
        const maxCount = document.getElementById('maxCount');
        const processPid = document.getElementById('processPid');
        const processStatus = document.getElementById('processStatus');
        const cancelButton = document.getElementById('cancelButton');
        const refreshButton = document.getElementById('refreshButton');
        const globalStatusMessage = document.getElementById('globalStatusMessage');

        let statusInterval = null;

        // Función para mostrar mensajes de estado
        function showStatus(message, type = 'info') {
            const bgColor = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 
                           type === 'error' ? 'bg-red-100 border-red-400 text-red-700' : 
                           'bg-blue-100 border-blue-400 text-blue-700';
            
            globalStatusMessage.className = `${bgColor} border px-4 py-3 rounded relative mb-4`;
            globalStatusMessage.innerHTML = `<span class="block sm:inline">${message}</span>`;
            globalStatusMessage.classList.remove('hidden');

            if (type !== 'error') {
                setTimeout(() => {
                    globalStatusMessage.classList.add('hidden');
                }, 5000);
            }
        }

        // Función para obtener el estado del proceso
        async function getProcessStatus() {
            try {
                const response = await fetch('/messages/process-status');
                const result = await response.json();
                
                if (result.success) {
                    return result.status;
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error obteniendo estado:', error);
                return null;
            }
        }

        // Función para actualizar la interfaz con el estado
        async function updateProcessStatus() {
            const status = await getProcessStatus();
            
            if (status) {
                // Actualizar contadores
                currentCount.textContent = status.current;
                maxCount.textContent = status.max;
                
                // Actualizar barra de progreso
                progressBar.style.width = status.progress + '%';
                progressText.textContent = `${status.current}/${status.max} mensajes enviados`;
                progressPercentage.textContent = `${status.progress}%`;
                
                // Actualizar información del proceso
                if (status.is_running) {
                    processPid.textContent = status.pid;
                    processStatus.textContent = 'Ejecutándose';
                    processStatus.className = 'text-green-600 font-medium';
                    
                    // Mostrar panel si está corriendo
                    if (progressPanel.classList.contains('hidden')) {
                        progressPanel.classList.remove('hidden');
                    }
                } else {
                    processStatus.textContent = 'Detenido';
                    processStatus.className = 'text-red-600 font-medium';
                    
                    // Si no hay proceso corriendo, detener el intervalo
                    if (statusInterval) {
                        clearInterval(statusInterval);
                        statusInterval = null;
                    }
                }
            }
        }

        // Función para iniciar el monitoreo del proceso
        function startStatusMonitoring() {
            if (!statusInterval) {
                statusInterval = setInterval(updateProcessStatus, 2000); // Actualizar cada 2 segundos
            }
        }

        // Función para guardar configuración
        async function saveConfiguration() {
            const selectedPhones = Array.from(document.querySelectorAll('.contact-checkbox:checked'))
                .map(cb => cb.getAttribute('data-phone'));
            const message = messageContent.value.trim();
            const frequency = document.getElementById('frequency').value;

            // Validaciones básicas
            if (selectedPhones.length === 0) {
                showStatus('Por favor selecciona al menos un usuario', 'error');
                return;
            }
            
            if (message.length < 10) {
                showStatus('El mensaje debe tener al menos 10 caracteres', 'error');
                return;
            }
            
            if (frequency < 60) {
                showStatus('La frecuencia mínima es de 60 segundos', 'error');
                return;
            }

            const dataToSave = {
                message: message,
                frequency: parseInt(frequency),
                selectedNumbers: selectedPhones,
                savedAt: new Date().toISOString()
            };

            try {
                saveButton.disabled = true;
                saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Guardando...</span>';

                const response = await fetch('/messages/save-configuration', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dataToSave)
                });

                const result = await response.json();

                if (result.success) {
                    showStatus(`✅ Configuración guardada para ${selectedPhones.length} usuario(s)`, 'success');
                } else {
                    showStatus('❌ Error al guardar: ' + (result.message || 'Error desconocido'), 'error');
                }

            } catch (error) {
                console.error('Error en guardado:', error);
                showStatus('❌ Error de conexión: ' + error.message, 'error');
            } finally {
                saveButton.disabled = false;
                saveButton.innerHTML = '<i class="fas fa-save"></i><span>Guardar Configuración</span>';
            }
        }

        // Función para ejecutar el script Python
        async function executePythonScript() {
            try {
                sendButton.disabled = true;
                const response = await fetch('/messages/execute-python-script', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const result = await response.json();
                
                if (result.success) {
                    showStatus('✅ Proceso iniciado correctamente (PID: ' + result.pid + ')', 'success');
                    progressPanel.classList.remove('hidden');
                    startStatusMonitoring();
                } else {
                    showStatus('❌ Error al iniciar proceso: ' + (result.message || 'Error desconocido'), 'error');
                    sendButton.disabled = false;
                }

            } catch (error) {
                console.error('Error ejecutando Python:', error);
                showStatus('❌ Error de conexión: ' + error.message, 'error');
                sendButton.disabled = false;
            }
        }

        // Función para cancelar el proceso
        async function cancelProcess() {
            try {
                cancelButton.disabled = true;
                cancelButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Cancelando...</span>';

                const response = await fetch('/messages/cancel-process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const result = await response.json();
                
                if (result.success) {
                    showStatus('✅ ' + result.message, 'success');
                    progressPanel.classList.add('hidden');
                    if (statusInterval) {
                        clearInterval(statusInterval);
                        statusInterval = null;
                    }
                } else {
                    showStatus('❌ ' + result.message, 'error');
                }

            } catch (error) {
                console.error('Error cancelando proceso:', error);
                showStatus('❌ Error cancelando proceso: ' + error.message, 'error');
            } finally {
                cancelButton.disabled = false;
                cancelButton.innerHTML = '<i class="fas fa-stop-circle"></i><span>Cancelar Envío</span>';
            }
        }

        // Función para cargar datos guardados
        async function loadSavedData() {
            try {
                const response = await fetch('/messages/get-saved-data');
                const result = await response.json();
                
                if (result.success && result.data) {
                    if (result.data.message) {
                        messageContent.value = result.data.message;
                        charCount.textContent = result.data.message.length + ' caracteres';
                    }
                    
                    if (result.data.frequency) {
                        document.getElementById('frequency').value = result.data.frequency;
                    }
                    
                    if (result.data.selectedNumbers && Array.isArray(result.data.selectedNumbers)) {
                        clientCheckboxes.forEach(checkbox => {
                            const phone = checkbox.getAttribute('data-phone');
                            if (result.data.selectedNumbers.includes(phone)) {
                                checkbox.checked = true;
                            }
                        });
                        updateSelectedClients();
                    }
                }
            } catch (error) {
                console.log('No se pudieron cargar los datos guardados:', error);
            }
        }

        // Función para actualizar selección de clientes
        function updateSelectedClients() {
            const selected = Array.from(document.querySelectorAll('.contact-checkbox:checked'));
            selectedCount.textContent = selected.length + ' usuario(s) seleccionado(s)';
            updateSelectAllCheckbox();
        }

        // Función para actualizar checkbox "Seleccionar todos"
        function updateSelectAllCheckbox() {
            const allChecked = clientCheckboxes.length > 0 && 
                Array.from(clientCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(clientCheckboxes).some(cb => cb.checked);
            
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        }

        // Event Listeners
        messageContent.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length + ' caracteres';
        });

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                clientCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateSelectedClients();
            });
        }

        clientCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedClients);
        });

        saveButton.addEventListener('click', function(e) {
            e.preventDefault();
            saveConfiguration();
        });

        sendButton.addEventListener('click', function() {
            executePythonScript();
        });

        cancelButton.addEventListener('click', function() {
            cancelProcess();
        });

        refreshButton.addEventListener('click', function() {
            updateProcessStatus();
        });

        // Inicialización
        document.addEventListener('DOMContentLoaded', async function() {
            updateSelectedClients();
            loadSavedData();
            
            // Verificar si hay un proceso corriendo al cargar la página
            const status = await getProcessStatus();
            if (status && status.is_running) {
                progressPanel.classList.remove('hidden');
                startStatusMonitoring();
            }
        });
    </script>
    @endpush
</x-layouts.app>
