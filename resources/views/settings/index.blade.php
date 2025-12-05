<x-layouts.app title="Configuración">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-3xl">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Configuración</h1>
                <p class="text-gray-600 dark:text-gray-400">Actualiza tu información personal y contraseña</p>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <form action="{{ route('settings.update') }}" method="POST" class="px-4 py-5 sm:p-6">
                    @csrf
                    @method('PUT')

                    <!-- Información Personal -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            Información Personal
                        </h2>

                        <!-- Nombre -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name', auth()->user()->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror"
                                placeholder="Ej: Juan Pérez"
                                required
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Correo Electrónico <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email', auth()->user()->email) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('email') border-red-500 @enderror"
                                placeholder="usuario@callcenter.com"
                                required
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            Cambiar Contraseña
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Deja estos campos en blanco si no deseas cambiar tu contraseña.
                        </p>

                        <!-- Contraseña Actual -->
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Contraseña Actual
                            </label>
                            <input 
                                type="password" 
                                name="current_password" 
                                id="current_password"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('current_password') border-red-500 @enderror"
                                placeholder="Ingresa tu contraseña actual"
                            >
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nueva Contraseña -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('password') border-red-500 @enderror"
                                placeholder="Mínimo 8 caracteres"
                            >
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                La contraseña debe tener al menos 8 caracteres
                            </p>
                        </div>

                        <!-- Confirmar Nueva Contraseña -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirmar Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Confirma tu nueva contraseña"
                            >
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white text-sm font-medium rounded-md transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                            <i class="fa-solid fa-save mr-2"></i>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</x-layouts.app>

