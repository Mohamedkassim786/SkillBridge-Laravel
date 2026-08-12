<x-layouts.student>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                    <a href="{{ route('student.live-classes.index') }}"
                        class="hover:text-rose-400 text-decoration-none">My Live Classes</a>
                    <span>/</span>
                    <span class="text-white">{{ $liveClass->title }}</span>
                </div>
                <h1 class="text-xl font-black text-white mt-1">📹 {{ $liveClass->title }}</h1>
            </div>

            <div class="flex items-center gap-3">
                <div
                    class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 text-xs font-bold border border-emerald-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Attendance Active: <span id="attendance-timer">00:00</span></span>
                </div>

                <a href="{{ route('student.live-classes.show', $liveClass->id) }}" id="leave-class-btn"
                    class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs text-decoration-none">
                    🚪 Leave Class
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Embedded Jitsi Meeting Container -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);"
            class="rounded-3xl p-4 shadow-2xl overflow-hidden">
            <div id="jitsi-container" class="w-full rounded-2xl overflow-hidden bg-black aspect-video min-h-[600px]">
            </div>
        </div>
    </div>

    <!-- Jitsi IFrame External API JS Integration & Heartbeat Tracker -->
    <script src="https://{{ $meetingOptions['domain'] }}/external_api.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const domain = "{{ $meetingOptions['domain'] }}";
            const options = {
                roomName: "{{ $meetingOptions['roomName'] }}",
                width: "100%",
                height: 650,
                parentNode: document.querySelector("#jitsi-container"),
                userInfo: {
                    displayName: @json($meetingOptions['userInfo']['displayName']),
                    email: @json($meetingOptions['userInfo']['email'])
                },
                configOverwrite: {
                    prejoinPageEnabled: true,
                    disableDeepLinking: true
                }
            };

            const api = new JitsiMeetExternalAPI(domain, options);

            // Attendance Heartbeat Engine (Every 60 seconds)
            let secondsElapsed = 0;
            const timerEl = document.getElementById('attendance-timer');

            setInterval(function () {
                secondsElapsed += 1;
                const mins = String(Math.floor(secondsElapsed / 60)).padStart(2, '0');
                const secs = String(secondsElapsed % 60).padStart(2, '0');
                if (timerEl) timerEl.textContent = `${mins}:${secs}`;
            }, 1000);

            function sendHeartbeat() {
                fetch("{{ route('student.live-classes.heartbeat', $liveClass->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).catch(err => console.log('Heartbeat ping background update'));
            }

            // Send initial heartbeat immediately & repeat every 60 seconds
            sendHeartbeat();
            const heartbeatInterval = setInterval(sendHeartbeat, 60000);

            // Leave Class Signal
            function sendLeaveSignal() {
                navigator.sendBeacon("{{ route('student.live-classes.leave', $liveClass->id) }}", new Blob([JSON.stringify({
                    _token: '{{ csrf_token() }}'
                })], { type: 'application/json' }));
            }

            window.addEventListener('beforeunload', sendLeaveSignal);

            const leaveBtn = document.getElementById('leave-class-btn');
            if (leaveBtn) {
                leaveBtn.addEventListener('click', function () {
                    sendLeaveSignal();
                });
            }
        });
    </script>
</x-layouts.student>