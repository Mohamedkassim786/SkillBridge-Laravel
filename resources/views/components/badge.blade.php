@props([
    'color' => 'gray', // primary, success, warning, danger, gray
])

@php
$colors = [
    'primary' => 'bg-blue-100 text-blue-800',
    'success' => 'bg-green-100 text-green-800',
    'warning' => 'bg-yellow-100 text-yellow-800',
    'danger' => 'bg-red-100 text-red-800',
    'gray' => 'bg-gray-100 text-gray-800',
];

$classes = $colors[$color] ?? $colors['gray'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {$classes}"]) }}>
    {{ $slot }}
</span>
