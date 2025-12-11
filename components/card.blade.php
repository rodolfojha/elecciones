@props([
    'title' => null,
    'value' => null,
    'subtitle' => null,
    'icon' => null, // Ahora puede ser una clase Font Awesome
    'color' => 'blue',
    'href' => null,
    'class' => ''
])

@php
    $colorClasses = [
        'blue' => 'bg-blue-100 dark:bg-blue-900 border-blue-200 dark:border-blue-800',
        'green' => 'bg-green-100 dark:bg-green-900 border-green-200 dark:border-green-800',
        'purple' => 'bg-purple-100 dark:bg-purple-900 border-purple-200 dark:border-purple-800',
        'yellow' => 'bg-yellow-100 dark:bg-yellow-900 border-yellow-200 dark:border-yellow-800',
        'red' => 'bg-red-100 dark:bg-red-900 border-red-200 dark:border-red-800',
        'black' => 'bg-gray-100 dark:bg-gray-900 border-gray-200 dark:border-gray-800',
    ];

    $iconColorClasses = [
        'blue' => 'text-blue-600 dark:text-blue-400',
        'green' => 'text-green-600 dark:text-green-400',
        'purple' => 'text-purple-600 dark:text-purple-400',
        'yellow' => 'text-yellow-600 dark:text-yellow-400',
        'red' => 'text-red-600 dark:text-red-400',
        'black' => 'text-gray-500 dark:text-white',
    ];
@endphp

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border {{ $colorClasses[$color] ?? $colorClasses['blue'] }} {{ $class }} flex flex-col h-full">
    @if($title || $slot->isNotEmpty())
        <div class="px-4 py-5 sm:p-6 flex flex-col flex-1">
            <!-- Fila superior: Título e icono -->
<div class="flex justify-between items-center mb-2">
    <p class="text-sm font-medium text-gray-900 dark:text-gray-400">{{ $title }}</p>
    @if($icon)
        <div class="text-xl {{ $iconColorClasses[$color] ?? 'text-black dark:text-white' }}">
            <i class="{{ $icon }} fa-xs"></i>
        </div>
    @endif
</div>

            <!-- Valor (número) -->
            @if($value)
                <p class="text-2xl mt-4 font-bold text-gray-900 dark:text-white">{{ $value }}</p>
            @endif

            <!-- Fila inferior: Subtítulo y enlace "Ver" - Siempre al fondo -->
            <div class="flex justify-between items-end mt-auto pt-4">
                <div class="flex-1">
                    @if($subtitle)
                        <p class="text-xs text-gray-500">{{ $subtitle }}</p>
                    @endif
                </div>
                
                @if($href)
                    <a href="{{ $href }}" class="inline-flex items-center text-xs font-medium text-gray-900 hover:text-black dark:text-gray-400 dark:hover:text-gray-300 transition-colors ml-4 shrink-0">
                        Ver
                        <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

