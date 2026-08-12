<div x-data="voiceRoomManager()" x-init="initRoom()" class="max-w-3xl mx-auto space-y-6 text-white">
    <!-- Top Bar -->
    <div class="flex items-center justify-between p-4 rounded-2xl border border-purple-800/40" style="background-color: #251237;">
        <div class="flex items-center gap-3">
            <a href="{{ route('student.practice.mock') }}" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white transition-all text-xs font-bold">
                ←
            </a>
            <div>
                <h1 class="text-sm font-bold text-white">{{ $interview->role }} Voice Session</h1>
                <p class="text-[11px] text-slate-400">Interviewer: Sarah</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 px-3 py-1 rounded-xl bg-slate-900 border border-slate-800 text-xs font-mono font-bold text-rose-400">
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                <span x-text="formatTime(elapsedSeconds)">00:00</span>
            </div>
            <span class="text-xs font-bold text-slate-400">Q{{ $currentSequence }}</span>
        </div>
    </div>

    <!-- Main Clean Voice Room -->
    <div class="rounded-3xl p-8 md:p-12 text-center border border-purple-800/40 shadow-2xl flex flex-col items-center justify-center space-y-8 min-h-[420px]" style="background-color: #251237;">
        <!-- AI Voice Orb -->
        <div class="relative flex items-center justify-center">
            <div class="absolute w-36 h-36 rounded-full bg-rose-500/20 transition-all duration-300"
                 :class="{ 'scale-125 animate-ping opacity-30': isAISpeaking, 'scale-110 opacity-20': isCandidateSpeaking }"></div>

            <div class="relative w-24 h-24 rounded-full bg-gradient-to-tr from-rose-500 to-indigo-600 p-1 shadow-2xl transition-all duration-300 transform"
                 :class="{ 'scale-110 shadow-rose-500/50': isAISpeaking, 'scale-105 shadow-indigo-500/50': isCandidateSpeaking }">
                <div class="w-full h-full bg-slate-900 rounded-full flex items-center justify-center text-3xl">
                    <template x-if="isAISpeaking"><span>🎙️</span></template>
                    <template x-if="isCandidateSpeaking"><span>🗣️</span></template>
                    <template x-if="!isAISpeaking && !isCandidateSpeaking"><span>✨</span></template>
                </div>
            </div>
        </div>

        <!-- Status Pill -->
        <div>
            <span x-show="isAISpeaking" class="px-4 py-1.5 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30 inline-flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span>
                Sarah is speaking...
            </span>
            <span x-show="isCandidateSpeaking" class="px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 inline-flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Listening to you...
            </span>
            <span x-show="!isAISpeaking && !isCandidateSpeaking" class="px-4 py-1.5 rounded-full text-xs font-bold bg-slate-800 text-slate-300 border border-slate-700">
                Ready
            </span>
        </div>

        <!-- Current Question -->
        <div class="max-w-xl space-y-2">
            <h2 class="text-xl font-bold text-white leading-relaxed">
                "{{ $currentQuestionText }}"
            </h2>
            <p class="text-xs text-emerald-300" x-show="liveTranscript">
                You: <span x-text="liveTranscript"></span>
            </p>
        </div>

        <!-- Toolbar -->
        <div class="flex items-center gap-3 pt-4">
            <button type="button" @click="toggleMute()"
                    class="px-4 py-2.5 rounded-xl border text-xs font-bold transition-all"
                    :class="isMuted ? 'bg-rose-500/20 border-rose-500 text-rose-300' : 'bg-slate-900 border-slate-800 text-slate-300 hover:border-slate-700'">
                <span x-text="isMuted ? '🔇 Unmute' : '🎙️ Mute'"></span>
            </button>

            <button type="button" wire:click="toggleTranscript"
                    class="px-4 py-2.5 rounded-xl border bg-slate-900 border-slate-800 text-slate-300 text-xs font-bold hover:border-slate-700 transition-all">
                <span>📄 Transcript</span>
            </button>

            <button type="button" wire:click="finishInterview"
                    class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold transition-all">
                <span>🛑 Finish & Get Report</span>
            </button>
        </div>
    </div>

    <!-- Transcript Box -->
    @if($showTranscript)
        <div class="p-6 rounded-3xl border border-purple-800/40 space-y-3" style="background-color: #251237;">
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider border-b border-slate-800 pb-2">Conversation History</h3>
            <div class="space-y-2 max-h-52 overflow-y-auto pr-1">
                @foreach($conversation as $item)
                    <div class="text-xs space-y-1">
                        <div class="text-rose-400 font-semibold">Sarah: {{ $item->question }}</div>
                        @if($item->response)
                            <div class="text-emerald-300 pl-3">You: {{ $item->response->transcript }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- JavaScript Audio & Interruption Engine -->
<script>
function voiceRoomManager() {
    return {
        isAISpeaking: false,
        isCandidateSpeaking: false,
        isInterrupted: false,
        isMuted: false,
        elapsedSeconds: 0,
        timerInterval: null,
        liveTranscript: '',
        recognition: null,
        speechUtterance: null,

        initRoom() {
            this.timerInterval = setInterval(() => { this.elapsedSeconds++; }, 1000);
            
            const initialText = {!! json_encode($currentQuestionText) !!};
            if (window.speechSynthesis.onvoiceschanged !== undefined) {
                window.speechSynthesis.onvoiceschanged = () => {
                    this.speakSarahText(initialText);
                };
            }
            this.speakSarahText(initialText);
            this.setupSpeechRecognition();
        },

        speakSarahText(text) {
            if (!('speechSynthesis' in window) || !text) return;
            
            // Clean HTML entities and symbols so text-to-speech engine never speaks '#039'
            let cleanText = text
                .replace(/&#039;/g, "'")
                .replace(/&quot;/g, '"')
                .replace(/&amp;/g, '&')
                .replace(/&lt;/g, '<')
                .replace(/&gt;/g, '>')
                .replace(/#/g, '');

            window.speechSynthesis.cancel();
            this.speechUtterance = new SpeechSynthesisUtterance(cleanText);
            this.speechUtterance.rate = 0.95;
            this.speechUtterance.pitch = 1.1;

            const voices = window.speechSynthesis.getVoices();
            const femaleVoice = voices.find(v => 
                v.name.includes('Zira') || 
                v.name.includes('Google US English') || 
                v.name.includes('Samantha') || 
                v.name.includes('Jenny') || 
                v.name.includes('Female') || 
                v.name.includes('Natural')
            ) || voices.find(v => v.lang.startsWith('en')) || null;

            if (femaleVoice) this.speechUtterance.voice = femaleVoice;

            this.speechUtterance.onstart = () => { this.isAISpeaking = true; };
            this.speechUtterance.onend = () => {
                this.isAISpeaking = false;
                this.startListeningCandidate();
            };

            window.speechSynthesis.speak(this.speechUtterance);
        },

        setupSpeechRecognition() {
            const SpeechRec = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRec) return;

            this.recognition = new SpeechRec();
            this.recognition.continuous = true;
            this.recognition.interimResults = true;
            this.recognition.lang = 'en-US';

            let silenceTimer = null;
            let currentSpeechDuration = 0;
            let speechStartTimestamp = 0;

            this.recognition.onstart = () => {
                this.isCandidateSpeaking = true;
                speechStartTimestamp = Date.now();
            };

            this.recognition.onresult = (event) => {
                let interim = '';
                let final = '';
                for (let i = event.resultIndex; i < event.results.length; ++i) {
                    if (event.results[i].isFinal) final += event.results[i][0].transcript;
                    else interim += event.results[i][0].transcript;
                }

                if (final || interim) {
                    this.liveTranscript = (final + ' ' + interim).trim();
                }

                // Handle Interruption: Candidate speaks while Sarah is speaking
                if (this.isAISpeaking && this.liveTranscript.trim().length > 3) {
                    window.speechSynthesis.cancel();
                    this.isAISpeaking = false;
                    this.isInterrupted = true;
                }

                // Silence Debounce (2.5s silence gap before auto-submitting answer)
                if (silenceTimer) clearTimeout(silenceTimer);

                if (this.liveTranscript.trim().length > 5 && !this.isAISpeaking) {
                    silenceTimer = setTimeout(() => {
                        const textToSend = this.liveTranscript.trim();
                        const durationSeconds = Math.max(3, Math.round((Date.now() - speechStartTimestamp) / 1000));
                        this.liveTranscript = '';

                        // Temporarily stop recognition while sending turn
                        try { this.recognition.stop(); } catch(e) {}

                        @this.call('submitCandidateTurn', textToSend, this.isInterrupted, durationSeconds);
                        this.isInterrupted = false;
                    }, 2500);
                }
            };

            this.recognition.onend = () => {
                this.isCandidateSpeaking = false;
                // Persistent Auto-Restart unless muted or AI is speaking
                if (!this.isMuted && !this.isAISpeaking) {
                    setTimeout(() => {
                        try { this.recognition.start(); } catch(e) {}
                    }, 400);
                }
            };
        },

        startListeningCandidate() {
            if (this.recognition && !this.isMuted) {
                try { this.recognition.start(); } catch(e) {}
            }
        },

        toggleMute() {
            this.isMuted = !this.isMuted;
            if (this.isMuted && this.recognition) {
                try { this.recognition.stop(); } catch(e) {}
            } else {
                this.startListeningCandidate();
            }
        },

        formatTime(sec) {
            const m = Math.floor(sec / 60).toString().padStart(2, '0');
            const s = (sec % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        }
    }
}

document.addEventListener('livewire:initialized', () => {
    Livewire.on('ai-spoken', (data) => {
        const room = Alpine.$data(document.querySelector('[x-data="voiceRoomManager()"]'));
        if (room && data.text) {
            room.speakSarahText(data.text);
        }
    });

    Livewire.on('interview-ending', () => {
        setTimeout(() => {
            const room = Alpine.$data(document.querySelector('[x-data="voiceRoomManager()"]'));
            if (room) {
                @this.call('finishInterview');
            }
        }, 6000);
    });
});
</script>
