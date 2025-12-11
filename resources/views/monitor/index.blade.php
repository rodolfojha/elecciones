<x-layouts.app title="Monitoreo de Operadores">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fa-solid fa-monitor-waveform mr-2 text-blue-600"></i>
                    Monitoreo en Tiempo Real
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Visualiza qué operador está atendiendo a cada cliente</p>
            </div>

            @livewire('operators-monitor')
        </div>
    </div>
</x-layouts.app>

