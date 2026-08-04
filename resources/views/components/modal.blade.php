@props([
    'name',
    'show' => false,
    'title' => null,
])

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:keydown.escape.window="show = false"
    style="display: {{ $show ? 'block' : 'none' }};"
    class="fixed inset-0 z-50 overflow-y-auto"
>
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" x-on:click="show = false"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl transition-all">
            @if ($title)
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                    <h3 class="text-lg font-bold text-primary-navy">{{ $title }}</h3>
                    <button x-on:click="show = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>
