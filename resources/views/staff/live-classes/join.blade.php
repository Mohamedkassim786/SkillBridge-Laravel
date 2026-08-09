<x-layouts.staff>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                    <a href="{{ route('staff.live-classes.index') }}"
                        class="hover:text-rose-400 text-decoration-none">Live Classes</a>
                    <span>/</span>
                    <span class="text-white">{{ $liveClass->title }}</span>
                </div>
                <h1 class="text-xl font-black text-white mt-1">📹 Host Live Jitsi Session: {{ $liveClass->title }}</h1>
            </div>

            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route('staff.live-classes.end', $liveClass->id) }}">
                    @csrf
                    <button type="submit" style="background-color: #D62828;"
                        class="px-5 py-2.5 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition">
                        🔴 End Broadcast & Complete Class
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Embedded Jitsi Meeting Container -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;"
            class="rounded-3xl p-4 shadow-2xl overflow-hidden">
            <div id="jitsi-container" class="w-full rounded-2xl overflow-hidden bg-black aspect-video min-h-[600px]">
            </div>
        </div>
    </div>

    <!-- Jitsi IFrame External API JS Integration -->
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
        });
    </script>
</x-layouts.staff>