@props([
    'variant' => 'primary', // primary, secondary, danger, outline
    'type' => 'button',
])

@php
$variants = [
    'primary' => 'bg-primary-navy hover:bg-secondary-navy text-white focus:ring-primary-navy',
    'secondary' => 'bg-action-red hover:bg-hover-red text-white focus:ring-action-red',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
    'outline' => 'border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 focus:ring-primary-navy',
];

$classes = $variants[$variant] ?? $variants['primary'];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "inline-flex items-center justify-center px-4 py-2.5 rounded-xl font-semibold text-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 shadow-sm {$classes}"]) }}>
    {{ $slot }}
</button>
