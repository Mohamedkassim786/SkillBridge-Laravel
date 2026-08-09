<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <span>Latest Activity Feed</span>
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
