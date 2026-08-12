<x-layouts.student>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                    <a href="{{ route('student.live-classes.index') }}" class="hover:text-rose-400 text-decoration-none">My Live Classes</a>
                    <span>/</span>
                    <span class="text-white">{{ $liveClass->title }}</span>
                </div>
                <h1 class="text-2xl font-black text-white mt-1">{{ $liveClass->title }}</h1>
            </div>

            @if (in_array($liveClass->status, ['scheduled', 'starting_soon', 'live']))
                <a href="{{ route('student.live-classes.join', $liveClass->id) }}" style="background-color: #D62828;" class="px-6 py-3 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition text-decoration-none">
                    📹 Join Jitsi Live Meeting Room
                </a>
            @endif
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Class Banner & Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="md:col-span-2 rounded-3xl p-6 shadow-xl text-white space-y-4">
                <h3 class="text-base font-black text-white">Class Agenda & Syllabus Overview</h3>
                <p class="text-xs text-slate-300 leading-relaxed">{{ $liveClass->description ?? 'Join your instructor and cohort peers for an interactive live technical session.' }}</p>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-800 text-xs">
                    <div>
                        <div class="text-slate-400 font-semibold">Course</div>
                        <div class="font-bold text-white mt-0.5">{{ $liveClass->course?->title }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-semibold">Trainer</div>
                        <div class="font-bold text-white mt-0.5">{{ $liveClass->trainer?->name ?? 'Enterprise Instructor' }}</div>
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
                        <div class="text-slate-400 font-semibold">Attendance Status</div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase mt-0.5 inline-block
                            {{ $attendee ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-slate-800 text-slate-400 border border-slate-700' }}">
                            {{ $attendee ? strtoupper($attendee->attendance_status) : 'Not Joined Yet' }}
                        </span>
                    </div>
                </div>

                <!-- Course Download Materials -->
                @if ($liveClass->materials->count() > 0)
                    <div class="pt-4 border-t border-slate-800 space-y-3">
                        <h4 class="text-xs font-black text-white">Class Study Materials & Attachments</h4>
                        <div class="space-y-2">
                            @foreach ($liveClass->materials as $mat)
                                <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3 rounded-2xl flex items-center justify-between text-xs text-white">
                                    <div>
                                        <div class="font-bold text-white">{{ $mat->title }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase font-semibold mt-0.5">{{ $mat->type }}</div>
                                    </div>
                                    @if ($mat->external_url)
                                        <a href="{{ $mat->external_url }}" target="_blank" style="background-color: #D62828;" class="px-3 py-1.5 rounded-xl text-white font-bold text-xs text-decoration-none">
                                            Open Link ➔
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Side Widget: Recording & Post-Class Feedback -->
            <div class="space-y-6">
                <!-- Recording Box -->
                <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-3xl p-6 shadow-xl text-white space-y-4">
                    <h3 class="text-base font-black text-white">Class Recording</h3>

                    @if ($liveClass->isPublishedRecording())
                        <p class="text-xs text-slate-300">The instructor has published the recording for this session.</p>
                        <a href="{{ route('student.live-classes.recording', $liveClass->id) }}" target="_blank" class="w-full py-3 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white font-black text-xs text-center block text-decoration-none shadow-lg">
                            🎬 Watch Class Video Recording
                        </a>
                    @else
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-xs text-slate-400 text-center">
                            Recording unavailable or pending publication.
                        </div>
                    @endif
                </div>

                <!-- Feedback Form -->
                <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-3xl p-6 shadow-xl text-white space-y-4">
                    <h3 class="text-base font-black text-white">Rate This Session</h3>

                    @if ($userFeedback)
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-2 text-xs">
                            <div class="text-amber-400 font-black">Rating: ⭐ {{ $userFeedback->rating }}/5</div>
                            <p class="text-slate-300">{{ $userFeedback->feedback }}</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('student.live-classes.feedback', $liveClass->id) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-300 mb-1">Rating</label>
                                <select name="rating" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2 rounded-xl text-xs font-bold">
                                    <option value="5" class="text-slate-900">⭐⭐⭐⭐⭐ (5/5) Excellent</option>
                                    <option value="4" class="text-slate-900">⭐⭐⭐⭐ (4/5) Very Good</option>
                                    <option value="3" class="text-slate-900">⭐⭐⭐ (3/5) Average</option>
                                    <option value="2" class="text-slate-900">⭐⭐ (2/5) Poor</option>
                                    <option value="1" class="text-slate-900">⭐ (1/5) Terrible</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-300 mb-1">Feedback</label>
                                <textarea name="feedback" rows="3" placeholder="Share your experience..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full p-3 rounded-xl text-xs focus:outline-none"></textarea>
                            </div>

                            <button type="submit" style="background-color: #D62828;" class="w-full py-2.5 rounded-xl text-white font-black text-xs shadow-md">
                                Submit Feedback
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.student>
