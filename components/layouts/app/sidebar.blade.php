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
                </flux:navlist.group>
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
                
                const groupHeadings = sidebar.querySelectorAll('[data-heading], .flux-navlist-group-heading, [class*="heading"]');
                groupHeadings.forEach(heading => {
                    heading.style.display = 'none';
                    heading.style.visibility = 'hidden';
                    heading.style.opacity = '0';
                });
            }
            
            // Función para mostrar títulos de grupos
            function showGroupHeadings() {
                const sidebar = document.getElementById('sidebar');
                if (!sidebar) return;
                
                const groupHeadings = sidebar.querySelectorAll('[data-heading], .flux-navlist-group-heading, [class*="heading"]');
                groupHeadings.forEach(heading => {
                    heading.style.display = '';
                    heading.style.visibility = '';
                    heading.style.opacity = '';
                });
            }
            
            // Función para inicializar el sidebar
            function initializeSidebar() {
                const sidebar = document.getElementById('sidebar');
                const toggleButton = document.getElementById('sidebar-toggle');
                
                if (!sidebar || !toggleButton) return;
                
                const toggleIcon = toggleButton.querySelector('svg');
                
                const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
                
                if (isCollapsed) {
                    sidebar.classList.add('sidebar-collapsed');
                    if (toggleIcon) {
                        toggleIcon.style.transform = 'rotate(180deg)';
                    }
                    hideGroupHeadings();
                } else {
                    if (toggleIcon) {
                        toggleIcon.style.transform = 'rotate(0deg)';
                    }
                    showGroupHeadings();
                }
                
                toggleButton.addEventListener('click', handleSidebarToggle);
            }
            
            // Función para manejar el toggle del sidebar
            function handleSidebarToggle() {
                const sidebar = document.getElementById('sidebar');
                const toggleButton = document.getElementById('sidebar-toggle');
                const toggleIcon = toggleButton.querySelector('svg');
                
                sidebar.classList.toggle('sidebar-collapsed');
                
                const isNowCollapsed = sidebar.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebar-collapsed', isNowCollapsed);
                
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
            
            // Aplicar estado colapsado inmediatamente al cargar
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', applyCollapsedState);
            } else {
                applyCollapsedState();
            }
            
            // Inicializar cuando se carga la página
            document.addEventListener('DOMContentLoaded', initializeSidebar);
            
            // Reinicializar cuando se navega (para Livewire/Alpine.js)
            document.addEventListener('livewire:navigated', initializeSidebar);
            document.addEventListener('alpine:init', initializeSidebar);
        </script>
    </body>
</html>

