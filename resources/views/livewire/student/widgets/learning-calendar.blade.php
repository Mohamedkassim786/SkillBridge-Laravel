<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <span>📅 Learning Schedule & Deadlines</span>
        </h3>
    </div>

    <div class="space-y-2.5">
        @foreach ($events as $ev)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl flex items-center justify-between gap-3 text-xs text-white">
                <div class="flex items-center gap-3">
                    <div style="background-color: #D62828;" class="px-2.5 py-1 rounded-lg text-white font-black text-[11px] whitespace-nowrap">
                        {{ $ev->date }} • {{ $ev->time }}
                    </div>
                    <span class="font-bold text-white truncate">{{ $ev->title }}</span>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 font-extrabold uppercase text-[9px] border border-slate-700">{{ $ev->type }}</span>
            </div>
        @endforeach
    </div>
</div>
