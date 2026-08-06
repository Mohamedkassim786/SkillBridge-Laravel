<x-layouts.staff>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                    <a href="{{ route('staff.live-classes.index') }}" class="hover:text-rose-400 text-decoration-none">Live Classes</a>
                    <span>/</span>
                    <span class="text-white">{{ $liveClass->title }}</span>
                </div>
                <h1 class="text-2xl font-black text-white mt-1">{{ $liveClass->title }}</h1>
            </div>

            <div class="flex items-center gap-2">
                @if (in_array($liveClass->status, ['scheduled', 'starting_soon', 'live']))
                    <a href="{{ route('staff.live-classes.join', $liveClass->id) }}" style="background-color: #D62828;" class="px-5 py-2.5 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition text-decoration-none">
                        📹 Launch Jitsi Live Room
                    </a>
                @endif
                <a href="{{ route('staff.live-classes.attendance', $liveClass->id) }}" class="px-4 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md text-decoration-none">
                    📊 View Attendance Report
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Overview Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="md:col-span-2 rounded-3xl p-6 shadow-xl text-white space-y-4">
                <h3 class="text-base font-black text-white">Class Details & Configuration</h3>
                <p class="text-xs text-slate-300 leading-relaxed">{{ $liveClass->description ?? 'No detailed agenda specified for this masterclass.' }}</p>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-800 text-xs">
                    <div>
                        <div class="text-slate-400 font-semibold">Course</div>
                        <div class="font-bold text-white mt-0.5">{{ $liveClass->course?->title }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Batch</div>
                        <div class="font-bold text-white mt-0.5">{{ $liveClass->batch?->name ?? 'All Enrolled' }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Scheduled Date</div>
                        <div class="font-bold text-white mt-0.5">{{ $liveClass->start_at->format('M d, Y @ h:i A') }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Duration</div>
                        <div class="font-bold text-white mt-0.5">{{ $liveClass->duration_minutes }} Minutes</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Status</div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase mt-0.5 inline-block bg-blue-500/20 text-blue-300 border border-blue-500/30">
                            {{ strtoupper($liveClass->status) }}
                        </span>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Jitsi Room ID</div>
                        <div class="font-mono text-[11px] text-slate-300 truncate mt-0.5">{{ $liveClass->room_name }}</div>
                    </div>
                </div>
            </div>

            <!-- Attendance & Recording Metrics Widget -->
            <div class="space-y-6">
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-4">
                    <h3 class="text-base font-black text-white">Attendance Summary</h3>
                    
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

                    <a href="{{ route('staff.live-classes.attendance', $liveClass->id) }}" style="background-color: #D62828;" class="w-full py-2.5 text-white font-black text-xs rounded-xl shadow-md text-center block text-decoration-none">
                        Manage & Export Attendance ➔
                    </a>
                </div>

                <!-- Recording Upload Section -->
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-4">
                    <h3 class="text-base font-black text-white">Session Video Recording</h3>

                    @if ($liveClass->isPublishedRecording())
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-2">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-black uppercase border border-emerald-500/30">
                                Published & Active
                            </span>
                            <p class="text-xs text-slate-300">Published on {{ $liveClass->published_at?->format('M d, Y') }}</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('staff.live-classes.upload-recording', $liveClass->id) }}" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input type="file" name="recording_file" accept="video/mp4,video/webm" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full p-2.5 rounded-xl text-xs">
                            <button type="submit" class="w-full py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md">
                                Upload MP4 Session Recording
                            </button>
                        </form>

                        @if ($liveClass->recording_status === 'processing' || $liveClass->recording_url)
                            <form method="POST" action="{{ route('staff.live-classes.publish-recording', $liveClass->id) }}">
                                @csrf
                                <button type="submit" style="background-color: #D62828;" class="w-full py-2.5 rounded-xl text-white font-black text-xs shadow-md">
                                    Publish Recording for Students
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.staff>
