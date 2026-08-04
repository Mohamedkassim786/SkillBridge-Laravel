@props([
    'title' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-sm border border-gray-100 p-6']) }}>
    @if ($title)
        <h3 class="text-lg font-bold text-primary-navy mb-4 border-b border-gray-100 pb-3">{{ $title }}</h3>
    @endif
    {{ $slot }}
</div>
