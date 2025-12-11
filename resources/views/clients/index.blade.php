<x-layouts.app title="Clientes">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Clientes</h1>
                <p class="text-gray-600 dark:text-gray-400">Lista de clientes esperando ser contactados</p>
            </div>

            <!-- Componente Livewire con actualización en tiempo real -->
            @livewire('clients-list')
        </div>
    </div>
</x-layouts.app>

