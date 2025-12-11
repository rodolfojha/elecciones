<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900" id="sidebar">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <!-- Botón para colapsar/expandir sidebar -->
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 rtl:space-x-reverse sidebar-logo" wire:navigate>
                    <x-app-logo />
                </a>
                <button id="sidebar-toggle" class="hidden lg:flex items-center justify-center w-8 h-8 rounded-md text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid sidebar-nav-group">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="sidebar-nav-item">
                        <span class="sidebar-text">{{ __('Dashboard') }}</span>
                    </flux:navlist.item>
                    {{-- OCULTO: Clientes
                    <flux:navlist.item icon="users" :href="route('clients.index')" :current="request()->routeIs('clients.index') || request()->routeIs('clients.show')" wire:navigate class="sidebar-nav-item">
                        <span class="sidebar-text">{{ __('Clientes') }}</span>
                    </flux:navlist.item>
                    --}}
                    @if(auth()->user()->isTrabajador() || auth()->user()->isAdmin())
                        <flux:navlist.item icon="user-plus" :href="route('voters.index')" :current="request()->routeIs('voters.*')" wire:navigate class="sidebar-nav-item">
                            <span class="sidebar-text">{{ __('Registro Personas') }}</span>
                        </flux:navlist.item>
                    @endif
                    {{-- OCULTO: Completados
                    <flux:navlist.item icon="check-circle" :href="route('clients.completed')" :current="request()->routeIs('clients.completed')" wire:navigate class="sidebar-nav-item">
                        <span class="sidebar-text">{{ __('Completados') }}</span>
                    </flux:navlist.item>
                    --}}
                    {{-- OCULTO: Monitoreo
                    @if(auth()->user()->isAdmin())
                        <flux:navlist.item icon="chart-bar" :href="route('monitor.index')" :current="request()->routeIs('monitor.*')" wire:navigate class="sidebar-nav-item">
                            <span class="sidebar-text">{{ __('Monitoreo') }}</span>
                        </flux:navlist.item>
                    @endif
                    --}}
                    @if(!auth()->user()->isAdmin())
                        <flux:navlist.item icon="clock" :href="route('history.index')" :current="request()->routeIs('history.*')" wire:navigate class="sidebar-nav-item">
                            <span class="sidebar-text">{{ __('Historial') }}</span>
                        </flux:navlist.item>
                    @endif
                    <flux:navlist.item icon="chat-bubble-left-right" :href="route('messages.index')" :current="request()->routeIs('messages.*')" wire:navigate class="sidebar-nav-item">
                        <span class="sidebar-text">{{ __('Mensajes') }}</span>
                    </flux:navlist.item>
                </flux:navlist.group>

                @if(auth()->user()->isAdmin())
                    <flux:navlist.group :heading="__('Administration')" class="grid sidebar-nav-group">
                        <flux:navlist.item icon="user-group" :href="route('trabajadores.index')" :current="request()->routeIs('trabajadores.*')" wire:navigate class="sidebar-nav-item">
                            <span class="sidebar-text">{{ __('Trabajadores') }}</span>
                        </flux:navlist.item>
                        {{-- OCULTO: Operadores y Cursos
                        <flux:navlist.item icon="user-group" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate class="sidebar-nav-item">
                            <span class="sidebar-text">{{ __('Operadores') }}</span>
                        </flux:navlist.item>
                        <flux:navlist.item icon="academic-cap" :href="route('courses.index')" :current="request()->routeIs('courses.*')" wire:navigate class="sidebar-nav-item">
                            <span class="sidebar-text">{{ __('Cursos') }}</span>
                        </flux:navlist.item>
                        --}}
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer class="sidebar-spacer" />


            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block sidebar-user-menu" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        
        @stack('scripts')
        
        <!-- Estilos para el sidebar colapsible -->
        <style>
            /* Forzar estado colapsado antes de que se renderice */
            body.sidebar-state-collapsed #sidebar {
                width: 4rem !important;
                min-width: 4rem !important;
                max-width: 4rem !important;
            }
            
            .sidebar-collapsed {
                width: 4rem !important;
                min-width: 4rem !important;
                max-width: 4rem !important;
                overflow: hidden;
            }
            
            .sidebar-collapsed .sidebar-logo {
                display: none;
            }
            
            .sidebar-collapsed .sidebar-text {
                display: none;
            }
            
            .sidebar-collapsed .sidebar-group-heading {
                display: none;
            }
            
            /* Ocultar los títulos de los grupos de Flux UI cuando está colapsado */
            .sidebar-collapsed [data-heading] {
                display: none !important;
            }
            
            .sidebar-collapsed .flux-navlist-group-heading {
                display: none !important;
            }
            
            .sidebar-collapsed [class*="heading"] {
                display: none !important;
            }
            
            /* Ocultar cualquier elemento que contenga texto de encabezado */
            .sidebar-collapsed h1,
            .sidebar-collapsed h2,
            .sidebar-collapsed h3,
            .sidebar-collapsed h4,
            .sidebar-collapsed h5,
            .sidebar-collapsed h6 {
                display: none !important;
            }
            
            /* Ocultar elementos de texto que contengan las palabras de los grupos */
            .sidebar-collapsed *:contains("Platform") {
                display: none !important;
            }
            
            /* Ocultar elementos con texto específico usando selectores de atributo */
            .sidebar-collapsed [data-test*="heading"],
            .sidebar-collapsed [aria-label*="heading"],
            .sidebar-collapsed [title*="Platform"] {
                display: none !important;
            }
            
            /* Selectores más agresivos para ocultar títulos */
            .sidebar-collapsed .flux-navlist-group > div:first-child,
            .sidebar-collapsed .flux-navlist-group > span:first-child,
            .sidebar-collapsed .flux-navlist-group > p:first-child,
            .sidebar-collapsed .flux-navlist-group > div[class*="text"],
            .sidebar-collapsed .flux-navlist-group > span[class*="text"],
            .sidebar-collapsed .flux-navlist-group > p[class*="text"] {
                display: none !important;
            }
            
            /* Ocultar cualquier elemento que contenga texto de los títulos específicos */
            .sidebar-collapsed *[class*="text-sm"][class*="font-medium"],
            .sidebar-collapsed *[class*="text-xs"][class*="font-medium"],
            .sidebar-collapsed *[class*="text-gray-500"],
            .sidebar-collapsed *[class*="text-gray-600"] {
                display: none !important;
            }
            
            /* Ocultar elementos que contengan texto específico usando JavaScript */
            .sidebar-collapsed .flux-navlist-group > *:not(.flux-navlist-item) {
                display: none !important;
            }
            
            .sidebar-collapsed .sidebar-spacer {
                display: none;
            }
            
            .sidebar-collapsed .sidebar-user-menu {
                display: none;
            }
            
            .sidebar-collapsed .sidebar-nav-item {
                justify-content: center;
                padding: 0.75rem;
            }
            
            .sidebar-collapsed .sidebar-nav-item svg {
                margin: 0;
            }
            
            .sidebar-collapsed .sidebar-nav-group {
                margin-bottom: 1rem;
            }
            
            .sidebar-collapsed .sidebar-nav-group:not(:last-child) {
                border-bottom: 1px solid rgb(229 231 235);
                padding-bottom: 1rem;
            }
            
            .sidebar-collapsed .sidebar-toggle-icon {
                transform: rotate(180deg);
            }
            
            .sidebar-collapsed .sidebar-toggle-icon svg {
                transform: rotate(180deg);
            }
            
            /* Ocultar scrollbar cuando está colapsado */
            .sidebar-collapsed {
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* Internet Explorer 10+ */
            }
            
            .sidebar-collapsed::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Opera */
            }
            
            .sidebar-collapsed * {
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* Internet Explorer 10+ */
            }
            
            .sidebar-collapsed *::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Opera */
            }
            
            /* Deshabilitar efectos hover cuando el sidebar está colapsado */
            .sidebar-collapsed .flux-navlist-item:hover,
            .sidebar-collapsed .flux-navlist-item:focus,
            .sidebar-collapsed .flux-navlist-item:active {
                background-color: transparent !important;
                color: inherit !important;
                transform: none !important;
                transition: none !important;
            }
            
            .sidebar-collapsed .flux-navlist-item:hover svg,
            .sidebar-collapsed .flux-navlist-item:focus svg,
            .sidebar-collapsed .flux-navlist-item:active svg {
                transform: none !important;
                transition: none !important;
            }
            
            /* Deshabilitar todas las transiciones cuando está colapsado */
            .sidebar-collapsed * {
                transition: none !important;
                animation: none !important;
            }
            
            /* Deshabilitar efectos hover en elementos específicos */
            .sidebar-collapsed a:hover,
            .sidebar-collapsed button:hover,
            .sidebar-collapsed [role="button"]:hover {
                background-color: transparent !important;
                color: inherit !important;
                transform: none !important;
                box-shadow: none !important;
            }
            
            /* Transiciones suaves */
            #sidebar {
                transition: width 0.3s ease-in-out, min-width 0.3s ease-in-out;
            }
            
            #sidebar .sidebar-text,
            #sidebar [data-heading],
            #sidebar .sidebar-spacer,
            #sidebar .sidebar-user-menu {
                transition: opacity 0.2s ease-in-out;
            }
        </style>
        
        <!-- JavaScript para el sidebar colapsible -->
        <script>
            // Función para aplicar el estado colapsado inmediatamente
            function applyCollapsedState() {
                const sidebar = document.getElementById('sidebar');
                if (!sidebar) return;
                
                const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
                
                if (isCollapsed) {
                    document.body.classList.add('sidebar-state-collapsed');
                    document.documentElement.classList.add('sidebar-state-collapsed');
                    sidebar.classList.add('sidebar-collapsed');
                    hideGroupHeadings();
                } else {
                    document.body.classList.remove('sidebar-state-collapsed');
                    document.documentElement.classList.remove('sidebar-state-collapsed');
                    sidebar.classList.remove('sidebar-collapsed');
                    showGroupHeadings();
                }
            }
            
            // Función para ocultar títulos de grupos
            function hideGroupHeadings() {
                const sidebar = document.getElementById('sidebar');
                if (!sidebar) return;
                
                // Buscar todos los posibles elementos que contengan títulos
                const groupHeadings = sidebar.querySelectorAll(`
                    [data-heading], 
                    .flux-navlist-group-heading, 
                    [class*="heading"],
                    .flux-navlist-group > div:first-child,
                    .flux-navlist-group > span:first-child,
                    .flux-navlist-group > p:first-child,
                    *[class*="text-sm"][class*="font-medium"],
                    *[class*="text-xs"][class*="font-medium"],
                    *[class*="text-gray-500"],
                    *[class*="text-gray-600"]
                `);
                
                groupHeadings.forEach(heading => {
                    heading.style.display = 'none';
                    heading.style.visibility = 'hidden';
                    heading.style.opacity = '0';
                    heading.style.height = '0';
                    heading.style.overflow = 'hidden';
                });
                
                // Buscar elementos que contengan texto específico
                const allElements = sidebar.querySelectorAll('*');
                allElements.forEach(element => {
                    const text = element.textContent?.trim();
                    if (text === 'Platform' || text === 'Administration') {
                        element.style.display = 'none';
                        element.style.visibility = 'hidden';
                        element.style.opacity = '0';
                        element.style.height = '0';
                        element.style.overflow = 'hidden';
                    }
                });
            }
            
            // Función para mostrar títulos de grupos
            function showGroupHeadings() {
                const sidebar = document.getElementById('sidebar');
                if (!sidebar) return;
                
                // Restaurar todos los textos del sidebar
                const sidebarTexts = sidebar.querySelectorAll('.sidebar-text');
                sidebarTexts.forEach(text => {
                    text.style.display = '';
                    text.style.visibility = '';
                    text.style.opacity = '';
                    text.style.width = '';
                    text.style.height = '';
                    text.style.overflow = '';
                });
                
                // Buscar todos los posibles elementos que contengan títulos
                const groupHeadings = sidebar.querySelectorAll(`
                    [data-heading], 
                    .flux-navlist-group-heading, 
                    [class*="heading"],
                    .flux-navlist-group > div:first-child,
                    .flux-navlist-group > span:first-child,
                    .flux-navlist-group > p:first-child,
                    *[class*="text-sm"][class*="font-medium"],
                    *[class*="text-xs"][class*="font-medium"],
                    *[class*="text-gray-500"],
                    *[class*="text-gray-600"]
                `);
                
                groupHeadings.forEach(heading => {
                    heading.style.display = '';
                    heading.style.visibility = '';
                    heading.style.opacity = '';
                    heading.style.height = '';
                    heading.style.overflow = '';
                });
                
                // Buscar elementos que contengan texto específico
                const allElements = sidebar.querySelectorAll('*');
                allElements.forEach(element => {
                    const text = element.textContent?.trim();
                    if (text === 'Platform') {
                        element.style.display = '';
                        element.style.visibility = '';
                        element.style.opacity = '';
                        element.style.height = '';
                        element.style.overflow = '';
                    }
                });
            }
            
            // Función para inicializar el sidebar
            function initializeSidebar() {
                const sidebar = document.getElementById('sidebar');
                const toggleButton = document.getElementById('sidebar-toggle');
                
                if (!sidebar || !toggleButton) return;
                
                const toggleIcon = toggleButton.querySelector('svg');
                
                // Remover event listeners existentes para evitar duplicados
                toggleButton.removeEventListener('click', handleSidebarToggle);
                
                // Verificar si el sidebar está colapsado (usando localStorage)
                const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
                
                if (isCollapsed) {
                    sidebar.classList.add('sidebar-collapsed');
                    if (toggleIcon) {
                        toggleIcon.style.transform = 'rotate(180deg)';
                    }
                    // Aplicar estado colapsado inmediatamente
                    hideGroupHeadings();
                } else {
                    if (toggleIcon) {
                        toggleIcon.style.transform = 'rotate(0deg)';
                    }
                    // Mostrar títulos si no está colapsado
                    showGroupHeadings();
                }
                
                // Event listener para el botón de toggle
                toggleButton.addEventListener('click', handleSidebarToggle);
            }
            
            // Función para manejar el toggle del sidebar
            function handleSidebarToggle() {
                const sidebar = document.getElementById('sidebar');
                const toggleButton = document.getElementById('sidebar-toggle');
                const toggleIcon = toggleButton.querySelector('svg');
                
                sidebar.classList.toggle('sidebar-collapsed');
                
                // Guardar el estado en localStorage
                const isNowCollapsed = sidebar.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebar-collapsed', isNowCollapsed);
                
                // Sincronizar con body
                if (isNowCollapsed) {
                    document.body.classList.add('sidebar-state-collapsed');
                    document.documentElement.classList.add('sidebar-state-collapsed');
                    hideGroupHeadings();
                    if (toggleIcon) toggleIcon.style.transform = 'rotate(180deg)';
                } else {
                    document.body.classList.remove('sidebar-state-collapsed');
                    document.documentElement.classList.remove('sidebar-state-collapsed');
                    showGroupHeadings();
                    if (toggleIcon) toggleIcon.style.transform = 'rotate(0deg)';
                }
            }
            
            // Función para reinicializar el sidebar
            function reinitializeSidebar() {
                applyCollapsedState();
                setTimeout(initializeSidebar, 50);
            }
            
            // Aplicar estado colapsado inmediatamente al cargar
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', applyCollapsedState);
            } else {
                applyCollapsedState();
            }
            
            // Inicializar cuando se carga la página
            document.addEventListener('DOMContentLoaded', initializeSidebar);
            
            // Reinicializar cuando se navega (para Livewire/Alpine.js)
            document.addEventListener('livewire:navigated', reinitializeSidebar);
            document.addEventListener('alpine:init', reinitializeSidebar);
            
            // Reinicializar cuando se actualiza el contenido
            document.addEventListener('livewire:updated', reinitializeSidebar);
            
            // Aplicar estado inmediatamente antes de la navegación
            document.addEventListener('beforeunload', applyCollapsedState);
            
            // Aplicar estado inmediatamente después de la navegación
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    applyCollapsedState();
                }
            });
            
            // Aplicar estado inmediatamente en cada cambio de página
            window.addEventListener('popstate', applyCollapsedState);
            
            // Manejar navegación con Livewire
            document.addEventListener('livewire:navigated', reinitializeSidebar);
            
            // Observar cambios en el DOM para reinicializar
            if (typeof MutationObserver !== 'undefined') {
                const observer = new MutationObserver(() => {
                    const toggleButton = document.getElementById('sidebar-toggle');
                    if (toggleButton && !toggleButton.hasAttribute('data-initialized')) {
                        toggleButton.setAttribute('data-initialized', 'true');
                        reinitializeSidebar();
                    }
                });
                
                observer.observe(document.body, { childList: true, subtree: true });
            }
        </script>
        
        <!-- Script para mantener modo claro siempre -->
        <script>
            (function() {
                function enforceLightMode() {
                    // Asegurar que siempre esté en modo claro
                    document.documentElement.classList.remove('dark');
                }

                // Aplicar inmediatamente
                enforceLightMode();

                // Re-aplicar después de navegaciones con Livewire
                document.addEventListener('livewire:navigated', function() {
                    setTimeout(enforceLightMode, 50);
                });

                document.addEventListener('livewire:updated', function() {
                    setTimeout(enforceLightMode, 50);
                });

                // También después de que Alpine.js inicialice
                document.addEventListener('alpine:init', function() {
                    setTimeout(enforceLightMode, 50);
                });
            })();
        </script>
    </body>
</html>
