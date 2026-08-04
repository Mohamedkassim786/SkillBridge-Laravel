<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
            <span>🔔 Latest Activity Feed</span>
        </h3>
    </div>

    <div class="space-y-3">
        @foreach ($notifications as $n)
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                <div class="w-2 h-2 rounded-full mt-1.5 {{ $n->read ? 'bg-slate-300' : 'bg-[#D62828]' }}"></div>
                <div class="flex-1">
                    <div class="flex items-center justify-between text-xs font-bold text-[#0B1F3A]">
                        <span>{{ $n->title }}</span>
                        <span class="text-[10px] text-slate-400 font-normal">{{ $n->time }}</span>
                    </div>
                    <div class="text-xs text-slate-600 mt-0.5">{{ $n->message }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
