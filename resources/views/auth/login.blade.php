<x-layouts.auth title="Iniciar Sesión">
    <x-auth-header 
        title="Bienvenido a CallCenter" 
        description="Ingresa tus credenciales para acceder al sistema" 
    />
    
    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <flux:field>
            <flux:label for="email">Correo Electrónico</flux:label>
            <flux:input 
                type="email" 
                id="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus
                autocomplete="username"
            />
            <flux:error name="email" />
        </flux:field>

        <!-- Password -->
        <flux:field>
            <flux:label for="password">Contraseña</flux:label>
            <flux:input 
                type="password" 
                id="password" 
                name="password" 
                required
                autocomplete="current-password"
            />
            <flux:error name="password" />
        </flux:field>

        <!-- Remember Me -->
        <flux:field>
            <flux:checkbox name="remember" id="remember">
                Recordarme
            </flux:checkbox>
        </flux:field>

        <div class="flex flex-col gap-3">
            <flux:button type="submit" class="w-full" variant="primary">
                Iniciar Sesión
            </flux:button>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-layouts.auth>

