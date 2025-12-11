<x-layouts.app title="Dashboard">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Sistema de gestión de call center</p>
            </div>

            <!-- Estadísticas principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <x-card
                    title="Bienvenido"
                    value="CallCenter"
                    subtitle="Sistema de gestión"
                    color="blue"
                    icon="fa-solid fa-headset"
                />
            </div>
        </div>
    </div>
</x-layouts.app>

