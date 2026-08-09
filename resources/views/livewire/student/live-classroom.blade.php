<div class="space-y-6 text-white">
    @php
        $isStaffUser = auth()->user()?->hasRole(['staff', 'trainer', 'admin', 'super_admin']);
        $backUrl = $isStaffUser ? route('staff.dashboard') : route('student.dashboard');
        $backText = $isStaffUser ? '← Back to Staff Dashboard' : '← Back to Student Dashboard';
    @endphp

    <!-- CLASSROOM HEADER BAR -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;"
        class="rounded-3xl p-6 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <span
                    class="px-3 py-1 bg-rose-600 text-white rounded-full text-xs font-black uppercase tracking-wider animate-pulse">🔴
                    LIVE NOW</span>
                <span class="text-xs font-extrabold text-slate-300">Cohort 2026 • Masterclass Stream</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black mt-2 text-white">
                {{ $event?->title ?? 'Enterprise Domain Architecture Masterclass' }}</h1>
            <p class="text-xs text-slate-300 mt-1">Instructor: <span
                    class="font-bold text-white">{{ $event?->instructor_name ?? 'Dr. Marcus Vance' }}</span> • Duration:
                {{ $event?->duration_mins ?? 60 }} mins</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ $backUrl }}" style="background: rgba(255,255,255,0.08); border: 1px solid #1e3a5f;"
                class="px-4 py-2.5 hover:bg-white/20 text-white rounded-xl text-xs font-bold transition text-decoration-none inline-block">
                {{ $backText }}
            </a>
        </div>
    </div>

    <!-- MAIN CLASSROOM GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- VIDEO PLAYER FRAME -->
        <div class="lg:col-span-2 space-y-4">
            <div style="border: 1px solid #1e3a5f;"
                class="bg-black rounded-3xl overflow-hidden shadow-2xl aspect-video relative">
                @if ($event?->meeting_url && (str_contains($event->meeting_url, 'youtube.com') || str_contains($event->meeting_url, 'youtu.be')))
                    <iframe class="w-full h-full"
                        src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?autoplay=1&modestbranding=1" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                @else
                    <!-- Jitsi Meet Free Live Classroom Iframe -->
                    <iframe class="w-full h-full"
                        src="https://meet.jit.si/SkillBridge_Masterclass_{{ $event?->id ?? 'demo' }}#userInfo.displayName=%22{{ urlencode(auth()->user()?->name ?? 'Instructor') }}%22"
                        allow="camera; microphone; display-capture; autoplay; clipboard-write" allowfullscreen></iframe>
                @endif
            </div>

            <!-- CLASS DESCRIPTION CARD -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;"
                class="rounded-3xl p-6 shadow-xl space-y-3 text-white">
                <h3 class="font-extrabold text-base text-white">About Today's Masterclass</h3>
                <p class="text-xs font-medium text-slate-300 leading-relaxed">
                    {{ $event?->description ?? 'Interactive live session covering Domain-Driven Design, Repository Pattern, and high-concurrency database optimizations in Laravel 12.' }}
                </p>
                <div class="pt-3 border-t border-slate-800 flex items-center gap-4 text-xs font-bold text-slate-400">
                    <span>📚 Resources: Architecture-Diagrams.pdf</span>
                    <span>💬 Active Students: Joined Live</span>
                </div>
            </div>
        </div>

        <!-- INTERACTIVE LIVE CHAT & Q&A SIDEBAR -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;"
            class="rounded-3xl p-6 shadow-xl flex flex-col h-[520px] text-white">
            <div class="pb-4 border-b border-slate-800 flex items-center justify-between">
                <h3 class="font-extrabold text-sm text-white flex items-center gap-2">
                    <span>💬 Live Chat & Q&A</span>
                </h3>
                <span
                    class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-[10px] font-black">ONLINE</span>
            </div>

            <!-- CHAT FEED -->
            <div class="flex-1 overflow-y-auto py-4 space-y-3 text-xs pr-1">
                @foreach ($chatMessages as $msg)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3 rounded-2xl">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-extrabold {{ $msg['is_instructor'] ? 'text-rose-400' : 'text-white' }}">
                                {{ $msg['user'] }}
                                @if ($msg['is_instructor']) <span
                                    class="ml-1 px-1.5 py-0.2 bg-rose-600 text-white rounded text-[9px]">INSTRUCTOR</span>
                                @endif
                            </span>
                            <span class="text-[10px] font-bold text-slate-400">{{ $msg['time'] }}</span>
                        </div>
                        <p class="text-slate-300 font-medium leading-normal">{{ $msg['message'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- CHAT INPUT FORM WITH TAILWIND LOADING SPINNER -->
            <form wire:submit.prevent="sendMessage" class="pt-3 border-t border-slate-800 flex items-center gap-2">
                <input type="text" wire:model="newMessage" placeholder="Ask a question or reply..."
                    style="background: #112240; border: 1px solid #1e3a5f; color: white;"
                    class="flex-1 px-3 py-2.5 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500 placeholder-slate-400">
                <button type="submit" wire:loading.attr="disabled" style="background-color: #D62828;"
                    class="px-4 py-2.5 text-white rounded-xl font-bold text-xs hover:bg-rose-700 transition flex items-center gap-1.5 disabled:opacity-50">
                    <span wire:loading.remove>Send</span>
                    <span wire:loading class="inline-flex items-center">
                        <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>