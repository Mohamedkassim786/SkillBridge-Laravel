@props([
    'headers' => [],
])

<div {{ $attributes->merge(['class' => 'overflow-x-auto rounded-xl border border-gray-100 shadow-sm bg-white']) }}>
    <table class="w-full text-left text-sm text-gray-600">
        @if (count($headers) > 0)
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-primary-navy border-b border-gray-100">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col" class="px-6 py-4">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-gray-100">
            {{ $slot }}
        </tbody>
    </table>
</div>
