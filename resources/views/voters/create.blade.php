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

                        <!-- Cédula -->
                        <div class="md:col-span-2">
                            <label for="cedula" class="block text-sm font-medium text-gray-700 mb-2">
                                Cédula de Ciudadanía <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="cedula" id="cedula" value="{{ old('cedula') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('cedula') border-red-500 @enderror"
                                placeholder="Ingrese el número de cédula"
                                pattern="[0-9]+"
                                title="Solo números">
                            @error('cedula')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror

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

                        <!-- Notas (visible para todos) -->
                        <div class="md:col-span-2">
                            <label for="notas" class="block text-sm font-medium text-gray-700 mb-2">
                                Notas adicionales
                            </label>
                            <textarea name="notas" id="notas" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Observaciones o notas adicionales...">{{ old('notas') }}</textarea>
                        </div>
                    </div>



                    <!-- Botones -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col lg:flex-row lg:justify-end gap-4">
                        @if(!auth()->user()->isTrabajador())
                            <a href="{{ route('voters.index') }}" 
                                class="w-full lg:w-auto px-6 py-3 lg:py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-center">
                                Cancelar
                            </a>
                        @endif
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
            if(btnConsultar) btnConsultar.disabled = true;
            if(iconSearch) iconSearch.classList.add('hidden');
            if(iconLoading) iconLoading.classList.remove('hidden');
            if(btnText) btnText.textContent = 'Consultando...';

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
                if(btnConsultar) btnConsultar.disabled = false;
                if(iconSearch) iconSearch.classList.remove('hidden');
                if(iconLoading) iconLoading.classList.add('hidden');
                if(btnText) btnText.textContent = 'Consultar';
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


