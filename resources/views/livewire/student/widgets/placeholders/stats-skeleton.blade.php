<div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-4">
    @for ($i = 0; $i < 7; $i++)
        <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
            <x-skeleton class="h-4 w-12" />
            <x-skeleton class="h-8 w-16" />
            <x-skeleton class="h-3 w-20" />
        </div>
    @endfor
</div>
