<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <span>🔔 Latest Activity Feed</span>
        </h3>
    </div>

    <div class="space-y-3">
        @foreach ($notifications as $n)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl flex items-start gap-3 text-white">
                <div class="w-2 h-2 rounded-full mt-1.5 {{ $n->read ? 'bg-slate-600' : 'bg-[#D62828]' }}"></div>
                <div class="flex-1">
                    <div class="flex items-center justify-between text-xs font-bold text-white">
                        <span>{{ $n->title }}</span>
                        <span class="text-[10px] text-slate-400 font-normal">{{ $n->time }}</span>
                    </div>
                    <div class="text-xs text-slate-300 mt-0.5">{{ $n->message }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
