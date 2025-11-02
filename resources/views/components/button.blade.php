@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'class' => ''
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none';

    $variantClasses = [
        'primary' => 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 border-transparent',
        'secondary' => 'text-gray-700 bg-white hover:bg-gray-50 focus:ring-blue-500 border-gray-300',
        'success' => 'text-white bg-green-600 hover:bg-green-700 focus:ring-green-500 border-transparent',
        'danger' => 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500 border-transparent',
        'warning' => 'text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500 border-transparent',
    ];

    $sizeClasses = [
        'sm' => 'px-3 py-2 text-sm leading-4 rounded-md',
        'md' => 'px-4 py-2 text-sm font-medium rounded-md',
        'lg' => 'px-6 py-3 text-base font-medium rounded-md',
    ];
@endphp

@isset($href)
    <a href="{{ $href }}" class="{{ $baseClasses }} {{ $variantClasses[$variant] ?? $variantClasses['primary'] }} {{ $sizeClasses[$size] ?? $sizeClasses['md'] }} {{ $class }}">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="{{ $baseClasses }} {{ $variantClasses[$variant] ?? $variantClasses['primary'] }} {{ $sizeClasses[$size] ?? $sizeClasses['md'] }} {{ $class }}">
        {{ $slot }}
    </button>
@endif

