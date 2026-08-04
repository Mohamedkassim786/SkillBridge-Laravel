<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
            <span>📅 Learning Schedule & Deadlines</span>
        </h3>
    </div>

    <div class="space-y-2.5">
        @foreach ($events as $ev)
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-3">
                    <div class="px-2.5 py-1 rounded-lg bg-[#0B1F3A] text-white font-bold text-[11px] whitespace-nowrap">
                        {{ $ev->date }} • {{ $ev->time }}
                    </div>
                    <span class="font-bold text-[#0B1F3A] truncate">{{ $ev->title }}</span>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-slate-200 text-slate-700 font-extrabold uppercase text-[9px]">{{ $ev->type }}</span>
            </div>
        @endforeach
    </div>
</div>
