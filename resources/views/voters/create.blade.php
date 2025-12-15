<x-layouts.app title="Registrar Persona">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- Encabezado -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Registrar Nueva Persona</h1>
                <p class="text-gray-600">Ingresa la cédula para obtener automáticamente el lugar de votación</p>
            </div>

            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow">
                <form method="POST" action="{{ route('voters.store') }}" id="voterForm" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror"
                                placeholder="Ingrese el nombre">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Apellido -->
                        <div>
                            <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">
                                Apellido <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('apellido') border-red-500 @enderror"
                                placeholder="Ingrese el apellido">
                            @error('apellido')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cédula con botón de consulta -->
                        <div class="md:col-span-2">
                            <label for="cedula" class="block text-sm font-medium text-gray-700 mb-2">
                                Cédula de Ciudadanía <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" name="cedula" id="cedula" value="{{ old('cedula') }}" required
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('cedula') border-red-500 @enderror"
                                    placeholder="Ingrese el número de cédula"
                                    pattern="[0-9]+"
                                    title="Solo números">
                                <button type="button" id="btnConsultar" onclick="consultarCedula()"
                                    class="w-full sm:w-auto px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                                    <svg id="iconSearch" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <svg id="iconLoading" class="animate-spin w-5 h-5 mr-2 hidden" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span id="btnText">Consultar</span>
                                </button>
                            </div>
                            @error('cedula')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-blue-800">
                                        <strong>Consulta automática:</strong> Al guardar, la información de votación se consultará automáticamente en segundo plano. Puedes continuar registrando más personas sin esperar.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono
                            </label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Número de teléfono">
                        </div>

                        <!-- Espacio -->
                        <div></div>
                    </div>

                    <!-- Sección de Información de Votación -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Información de Votación
                            <span class="ml-2 text-sm font-normal text-gray-500">(Se completa automáticamente al consultar la cédula)</span>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Departamento -->
                            <div>
                                <label for="departamento" class="block text-sm font-medium text-gray-700 mb-2">
                                    Departamento
                                </label>
                                <input type="text" name="departamento" id="departamento" value="{{ old('departamento') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                                    placeholder="Se obtiene automáticamente">
                            </div>

                            <!-- Municipio -->
                            <div>
                                <label for="municipio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Municipio
                                </label>
                                <input type="text" name="municipio" id="municipio" value="{{ old('municipio') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                                    placeholder="Se obtiene automáticamente">
                            </div>

                            <!-- Puesto de Votación -->
                            <div class="md:col-span-2">
                                <label for="puesto_votacion" class="block text-sm font-medium text-gray-700 mb-2">
                                    Puesto de Votación
                                </label>
                                <input type="text" name="puesto_votacion" id="puesto_votacion" value="{{ old('puesto_votacion') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                                    placeholder="Se obtiene automáticamente">
                            </div>

                            <!-- Dirección del Puesto -->
                            <div class="md:col-span-2">
                                <label for="direccion_puesto" class="block text-sm font-medium text-gray-700 mb-2">
                                    Dirección del Puesto de Votación
                                </label>
                                <textarea name="direccion_puesto" id="direccion_puesto" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                                    placeholder="Se obtiene automáticamente">{{ old('direccion_puesto') }}</textarea>
                            </div>

                            <!-- Mesa -->
                            <div>
                                <label for="mesa" class="block text-sm font-medium text-gray-700 mb-2">
                                    Mesa
                                </label>
                                <input type="text" name="mesa" id="mesa" value="{{ old('mesa') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                                    placeholder="Se obtiene automáticamente">
                            </div>

                            <!-- Notas -->
                            <div class="md:col-span-2">
                                <label for="notas" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notas adicionales
                                </label>
                                <textarea name="notas" id="notas" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Observaciones o notas adicionales...">{{ old('notas') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col lg:flex-row lg:justify-end gap-4">
                        <a href="{{ route('voters.index') }}" 
                            class="w-full lg:w-auto px-6 py-3 lg:py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-center">
                            Cancelar
                        </a>
                        <button type="submit" 
                            class="w-full lg:w-auto px-6 py-3 lg:py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Guardar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        async function consultarCedula() {
            const cedula = document.getElementById('cedula').value.trim();
            
            if (!cedula || cedula.length < 5) {
                alert('Por favor ingrese un número de cédula válido');
                return;
            }

            const btnConsultar = document.getElementById('btnConsultar');
            const iconSearch = document.getElementById('iconSearch');
            const iconLoading = document.getElementById('iconLoading');
            const btnText = document.getElementById('btnText');

            // Mostrar estado de carga en el botón
            btnConsultar.disabled = true;
            iconSearch.classList.add('hidden');
            iconLoading.classList.remove('hidden');
            btnText.textContent = 'Consultando...';

            try {
                const response = await fetch('{{ route("voters.consultar-cedula") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ cedula: cedula })
                });

                const result = await response.json();

                if (result.success && result.data) {
                    // Llenar los campos con la información obtenida
                    if (result.data.departamento) {
                        document.getElementById('departamento').value = result.data.departamento;
                    }
                    if (result.data.municipio) {
                        document.getElementById('municipio').value = result.data.municipio;
                    }
                    if (result.data.puesto_votacion) {
                        document.getElementById('puesto_votacion').value = result.data.puesto_votacion;
                    }
                    if (result.data.direccion_puesto) {
                        document.getElementById('direccion_puesto').value = result.data.direccion_puesto;
                    }
                    if (result.data.mesa) {
                        document.getElementById('mesa').value = result.data.mesa;
                    }
                    
                    // Cambiar color del fondo de los campos llenados
                    document.getElementById('departamento').classList.remove('bg-gray-50');
                    document.getElementById('departamento').classList.add('bg-green-50');
                    document.getElementById('municipio').classList.remove('bg-gray-50');
                    document.getElementById('municipio').classList.add('bg-green-50');
                    document.getElementById('puesto_votacion').classList.remove('bg-gray-50');
                    document.getElementById('puesto_votacion').classList.add('bg-green-50');
                    document.getElementById('direccion_puesto').classList.remove('bg-gray-50');
                    document.getElementById('direccion_puesto').classList.add('bg-green-50');
                    document.getElementById('mesa').classList.remove('bg-gray-50');
                    document.getElementById('mesa').classList.add('bg-green-50');
                } else {
                    // Mostrar error en consola o con alert si es necesario
                    console.error('Error:', result.message || 'No se encontró información para esta cédula');
                }

            } catch (error) {
                console.error('Error:', error);
            } finally {
                // Restaurar botón
                btnConsultar.disabled = false;
                iconSearch.classList.remove('hidden');
                iconLoading.classList.add('hidden');
                btnText.textContent = 'Consultar';
            }
        }

        // También consultar cuando se presiona Enter en el campo de cédula
        document.getElementById('cedula').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                consultarCedula();
            }
        });
    </script>
    @endpush
</x-layouts.app>


