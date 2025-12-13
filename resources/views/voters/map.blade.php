<x-layouts.app title="Mapa de Lugares de Votación">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- Encabezado -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Mapa de Lugares de Votación</h1>
                    <p class="text-gray-600">Visualiza todos los puestos de votación de las personas registradas</p>
                </div>
                <a href="{{ route('voters.index') }}" 
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Listado
                </a>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total de Lugares</p>
                            <p class="text-2xl font-bold text-gray-900" id="totalLocations">{{ $voters->unique('puesto_votacion')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Personas Registradas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $voters->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Municipios</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $voters->unique('municipio')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mapa -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div id="map" style="height: 600px; width: 100%;"></div>
            </div>

            <!-- Lista de lugares -->
            <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Lugares de Votación</h2>
                </div>
                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @forelse($voters->groupBy('puesto_votacion') as $puesto => $votantes)
                        <div class="p-4 hover:bg-gray-50 cursor-pointer location-item" 
                             data-location="{{ $puesto }}"
                             onclick="focusLocation('{{ $puesto }}')">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $puesto }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $votantes->first()->direccion_puesto }}</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $votantes->first()->municipio }}, {{ $votantes->first()->departamento }}
                                    </p>
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $votantes->count() }} {{ $votantes->count() === 1 ? 'persona' : 'personas' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="mt-2">No hay lugares de votación registrados</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let map;
        let markers = [];
        let infoWindows = [];

        // Datos de votantes agrupados por puesto
        const votersData = @json($voters->groupBy('puesto_votacion'));

        function initMap() {
            // Centro de Colombia como punto inicial
            const colombia = { lat: 4.570868, lng: -74.297333 };

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: colombia,
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: true,
            });

            // Agregar marcadores para cada puesto de votación
            Object.entries(votersData).forEach(([puesto, votantes]) => {
                if (votantes.length > 0) {
                    const voter = votantes[0];
                    
                    // Construir dirección más precisa incluyendo el nombre del puesto
                    const address = `${puesto}, ${voter.direccion_puesto}, ${voter.municipio}, ${voter.departamento}, Colombia`;

                    // Geocodificar la dirección
                    geocodeAddress(address, puesto, votantes);
                }
            });
        }

        function geocodeAddress(address, puesto, votantes) {
            const geocoder = new google.maps.Geocoder();
            const voter = votantes[0];

            // Estrategia 1: Buscar con el nombre del puesto + dirección completa
            const addressWithPuesto = `${puesto}, ${voter.direccion_puesto}, ${voter.municipio}, ${voter.departamento}, Colombia`;
            
            geocoder.geocode({ 
                address: addressWithPuesto,
                componentRestrictions: {
                    country: 'CO'
                }
            }, (results, status) => {
                if (status === 'OK' && results[0].geometry.location_type !== 'APPROXIMATE') {
                    // Si encontró una ubicación precisa, usar esa
                    createMarker(results[0].geometry.location, puesto, votantes);
                } else {
                    // Estrategia 2 (Fallback): Buscar solo con dirección + municipio
                    console.log(`Búsqueda con puesto no fue precisa para: ${puesto}. Intentando con dirección...`);
                    
                    const addressOnly = `${voter.direccion_puesto}, ${voter.municipio}, ${voter.departamento}, Colombia`;
                    
                    geocoder.geocode({ 
                        address: addressOnly,
                        componentRestrictions: {
                            country: 'CO'
                        }
                    }, (results2, status2) => {
                        if (status2 === 'OK') {
                            createMarker(results2[0].geometry.location, puesto, votantes);
                        } else {
                            console.error('Geocode falló para: ' + puesto + ' debido a: ' + status2);
                        }
                    });
                }
            });
        }

        function createMarker(location, puesto, votantes) {
            // Crear marcador
            const marker = new google.maps.Marker({
                map: map,
                position: location,
                title: puesto,
                animation: google.maps.Animation.DROP,
            });

            // Crear contenido del InfoWindow
            const contentString = `
                <div style="max-width: 300px;">
                    <h3 style="font-weight: bold; margin-bottom: 8px; color: #1f2937;">${puesto}</h3>
                    <p style="color: #6b7280; margin-bottom: 4px; font-size: 14px;">${votantes[0].direccion_puesto}</p>
                    <p style="color: #9ca3af; margin-bottom: 8px; font-size: 13px;">${votantes[0].municipio}, ${votantes[0].departamento}</p>
                    <div style="border-top: 1px solid #e5e7eb; padding-top: 8px; margin-top: 8px;">
                        <p style="font-weight: 600; color: #2563eb; margin-bottom: 8px;">
                            ${votantes.length} ${votantes.length === 1 ? 'persona registrada' : 'personas registradas'}
                        </p>
                        <div style="max-height: 150px; overflow-y: auto;">
                            ${votantes.map(v => `
                                <div style="padding: 4px 0; border-bottom: 1px solid #f3f4f6;">
                                    <span style="font-size: 13px; color: #374151;">${v.nombre} ${v.apellido}</span>
                                    <span style="font-size: 12px; color: #9ca3af; margin-left: 8px;">Mesa: ${v.mesa || 'N/A'}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;

            const infoWindow = new google.maps.InfoWindow({
                content: contentString,
            });

            marker.addListener('click', () => {
                // Cerrar todos los InfoWindows abiertos
                infoWindows.forEach(iw => iw.close());
                infoWindow.open(map, marker);
            });

            markers.push({ marker, puesto, infoWindow });
            infoWindows.push(infoWindow);

            // Ajustar el mapa para mostrar todos los marcadores
            if (markers.length === Object.keys(votersData).length) {
                const bounds = new google.maps.LatLngBounds();
                markers.forEach(m => bounds.extend(m.marker.getPosition()));
                map.fitBounds(bounds);
            }
        }

        function focusLocation(puesto) {
            const markerData = markers.find(m => m.puesto === puesto);
            if (markerData) {
                map.setZoom(15);
                map.setCenter(markerData.marker.getPosition());
                
                // Cerrar todos los InfoWindows
                infoWindows.forEach(iw => iw.close());
                
                // Abrir el InfoWindow del marcador seleccionado
                markerData.infoWindow.open(map, markerData.marker);
                
                // Animar el marcador
                markerData.marker.setAnimation(google.maps.Animation.BOUNCE);
                setTimeout(() => markerData.marker.setAnimation(null), 2000);
            }
        }
    </script>
    
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
    @endpush
</x-layouts.app>
