<x-layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                    <a href="{{ route('admin.live-classes.index') }}" class="hover:text-rose-400 text-decoration-none">Admin Live Classes</a>
                    <span>/</span>
                    <span class="text-white">{{ $liveClass->title }}</span>
                </div>
                <h1 class="text-2xl font-black text-white mt-1">{{ $liveClass->title }}</h1>
            </div>

            <a href="{{ route('admin.live-classes.attendance', $liveClass->id) }}" class="px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md text-decoration-none">
                📊 Audit Attendance Report
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="md:col-span-2 rounded-3xl p-6 shadow-xl text-white space-y-4">
                <h3 class="text-base font-black text-white">Class Information & Governance</h3>
                <p class="text-xs text-slate-300 leading-relaxed">{{ $liveClass->description ?? 'No detailed description specified.' }}</p>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-800 text-xs">
                    <div>
                        <div class="text-slate-400 font-semibold">Course</div>
                        <div class="font-bold text-white mt-0.5">{{ $liveClass->course?->title }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Trainer</div>
                        <div class="font-bold text-white mt-0.5">{{ $liveClass->trainer?->name }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Scheduled Date</div>
                        <div class="font-bold text-white mt-0.5">{{ $liveClass->start_at->format('M d, Y @ h:i A') }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Status</div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase mt-0.5 inline-block bg-blue-500/20 text-blue-300 border border-blue-500/30">
                            {{ strtoupper($liveClass->status) }}
                        </span>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Jitsi Room Name</div>
                        <div class="font-mono text-[11px] text-slate-300 truncate mt-0.5">{{ $liveClass->room_name }}</div>
                    </div>
                </div>

                <!-- Admin Cancel Action Form -->
                @if ($liveClass->status !== 'cancelled')
                    <div class="pt-4 border-t border-slate-800 space-y-3">
                        <h4 class="text-xs font-black text-rose-400">Admin Cancellation Override</h4>
                        <form method="POST" action="{{ route('admin.live-classes.cancel', $liveClass->id) }}" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <input type="text" name="cancellation_reason" required placeholder="Specify administrative cancellation reason..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs">
                            <button type="submit" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white font-black text-xs shadow-md">
                                🚫 Cancel Live Class
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Attendance & Recording Metrics Widget -->
            <div class="space-y-6">
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-4">
                    <h3 class="text-base font-black text-white">Attendance Audit Summary</h3>
                    
                    <div class="grid grid-cols-2 gap-3 text-center">
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl">
                            <div class="text-2xl font-black text-white">{{ $attendedCount }} / {{ $totalEnrolled }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase mt-1">Students Joined</div>
                        </div>
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl">
                            <div class="text-2xl font-black text-emerald-400">{{ $attendancePercentage }}%</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase mt-1">Attendance Rate</div>
                        </div>
                    </div>
                </div>

                <!-- Recording Status -->
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-4">
                    <h3 class="text-base font-black text-white">Recording Audit</h3>
                    @if ($liveClass->isPublishedRecording())
                        <a href="{{ route('admin.live-classes.recording', $liveClass->id) }}" target="_blank" class="w-full py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs text-center block text-decoration-none shadow-md">
                            🎬 Stream Video Recording
                        </a>
                    @else
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-xs text-slate-400 text-center">
                            No active recording published for this class.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
