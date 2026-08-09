<div class="space-y-6 text-white">
    <!-- Top Breadcrumb & Course Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                <a href="{{ route('student.courses.index') }}" class="hover:text-rose-400 text-decoration-none">My Courses</a>
                <span>/</span>
                <a href="{{ route('student.courses.show', $course->id) }}" class="hover:text-rose-400 text-decoration-none">{{ $course->title }}</a>
            </div>
            <h1 class="text-xl font-black text-white mt-1 flex items-center gap-3">
                <span>{{ $activeLesson?->title ?? 'Select a Lesson' }}</span>
                @if ($isCompleted)
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-black border border-emerald-500/30">✓ Completed</span>
                @endif
            </h1>
        </div>

        <a href="{{ route('student.courses.show', $course->id) }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs text-decoration-none">
            Back to Course Syllabus
        </a>
    </div>

    <!-- Main Player Split Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left 2 Columns: Video Player & Controls -->
        <div class="lg:col-span-2 space-y-6"            <!-- Video/Media Player Container -->
            <div class="rounded-3xl bg-black overflow-hidden shadow-2xl border border-slate-800 relative select-none"
                 x-data="{
                    playing: false,
                    currentTime: 0,
                    duration: 0,
                    isSeeking: false,
                    seekingPercent: 0,
                    volume: 1,
                    muted: false,
                    showControls: true,
                    hideTimer: null,
                    userActivity() {
                        this.showControls = true;
                        clearTimeout(this.hideTimer);
                        if (this.playing) {
                            this.hideTimer = setTimeout(() => {
                                this.showControls = false;
                            }, 2500);
                        }
                    },
                    getVideo() {
                        return this.$refs.videoPlayer || this.$el.querySelector('video') || this.$el.querySelector('audio');
                    },
                    formatTime(sec) {
                        if (isNaN(sec) || sec < 0) return '00:00';
                        let h = Math.floor(sec / 3600);
                        let m = Math.floor((sec % 3600) / 60);
                        let s = Math.floor(sec % 60);
                        if (h > 0) {
                            return `${h}:${m < 10 ? '0' : ''}${m}:${s < 10 ? '0' : ''}${s}`;
                        }
                        return `${m < 10 ? '0' : ''}${m}:${s < 10 ? '0' : ''}${s}`;
                    },
                    togglePlay() {
                        let v = this.getVideo();
                        if (!v) return;
                        if (v.paused) {
                            v.play().then(() => {
                                this.playing = true;
                                this.userActivity();
                            }).catch(() => {});
                        } else {
                            v.pause();
                            this.playing = false;
                            this.showControls = true;
                        }
                    },
                    skip(seconds) {
                        let v = this.getVideo();
                        if (!v) return;
                        let d = v.duration || this.duration || 0;
                        let target = Math.max(0, Math.min(d, (v.currentTime || 0) + seconds));
                        v.currentTime = target;
                        this.currentTime = target;
                        this.userActivity();
                    },
                    updateSeekPosition(e) {
                        let v = this.getVideo();
                        let bar = this.$refs.progressBar;
                        if (!v || !bar) return;
                        let rect = bar.getBoundingClientRect();
                        let clientX = e.touches ? e.touches[0].clientX : e.clientX;
                        let pos = Math.max(0, Math.min(1, (clientX - rect.left) / rect.width));
                        let d = v.duration || this.duration || 0;
                        let targetTime = pos * d;
                        this.seekingPercent = pos * 100;
                        if (this.isSeeking) {
                            this.currentTime = targetTime;
                        } else {
                            v.currentTime = targetTime;
                            this.currentTime = targetTime;
                        }
                    },
                    startSeeking(e) {
                        e.preventDefault();
                        this.isSeeking = true;
                        this.userActivity();
                        this.updateSeekPosition(e);

                        let onMove = (evt) => {
                            if (this.isSeeking) {
                                this.updateSeekPosition(evt);
                            }
                        };

                        let onEnd = (evt) => {
                            if (this.isSeeking) {
                                let v = this.getVideo();
                                let bar = this.$refs.progressBar;
                                if (v && bar) {
                                    let rect = bar.getBoundingClientRect();
                                    let clientX = evt.changedTouches ? evt.changedTouches[0].clientX : (evt.clientX || e.clientX);
                                    let pos = Math.max(0, Math.min(1, (clientX - rect.left) / rect.width));
                                    let d = v.duration || this.duration || 0;
                                    v.currentTime = pos * d;
                                    this.currentTime = pos * d;
                                }
                                this.isSeeking = false;
                                this.userActivity();
                            }
                            window.removeEventListener('mousemove', onMove);
                            window.removeEventListener('touchmove', onMove);
                            window.removeEventListener('pointermove', onMove);
                            window.removeEventListener('mouseup', onEnd);
                            window.removeEventListener('touchend', onEnd);
                            window.removeEventListener('pointerup', onEnd);
                        };

                        window.addEventListener('mousemove', onMove, { passive: false });
                        window.addEventListener('touchmove', onMove, { passive: false });
                        window.addEventListener('pointermove', onMove, { passive: false });
                        window.addEventListener('mouseup', onEnd);
                        window.addEventListener('touchend', onEnd);
                        window.addEventListener('pointerup', onEnd);
                    },
                    setVolume(val) {
                        let v = this.getVideo();
                        if (!v) return;
                        this.volume = Math.max(0, Math.min(1, val));
                        v.volume = this.volume;
                        this.muted = (this.volume === 0);
                    },
                    toggleMute() {
                        let v = this.getVideo();
                        if (!v) return;
                        this.muted = !this.muted;
                        v.muted = this.muted;
                    },
                    toggleFullscreen() {
                        let elem = this.$refs.playerAspect || this.$el.querySelector('.aspect-video') || this.$el;
                        let v = this.getVideo();
                        if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.mozFullScreenElement && !document.msFullscreenElement) {
                            if (elem && elem.requestFullscreen) {
                                elem.requestFullscreen();
                            } else if (elem && elem.webkitRequestFullscreen) {
                                elem.webkitRequestFullscreen();
                            } else if (elem && elem.mozRequestFullScreen) {
                                elem.mozRequestFullScreen();
                            } else if (elem && elem.msRequestFullscreen) {
                                elem.msRequestFullscreen();
                            } else if (v) {
                                if (v.requestFullscreen) v.requestFullscreen();
                                else if (v.webkitEnterFullscreen) v.webkitEnterFullscreen();
                            }
                        } else {
                            if (document.exitFullscreen) {
                                document.exitFullscreen();
                            } else if (document.webkitExitFullscreen) {
                                document.webkitExitFullscreen();
                            } else if (document.mozCancelFullScreen) {
                                document.mozCancelFullScreen();
                            } else if (document.msExitFullscreen) {
                                document.msExitFullscreen();
                            }
                        }
                    },
                    handleKeydown(e) {
                        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) return;

                        if (e.code === 'Space' || e.key === 'k' || e.key === 'K') {
                            e.preventDefault();
                            this.togglePlay();
                        } else if (e.key === 'ArrowRight' || e.key === 'l' || e.key === 'L') {
                            e.preventDefault();
                            this.skip(10);
                        } else if (e.key === 'ArrowLeft' || e.key === 'j' || e.key === 'J') {
                            e.preventDefault();
                            this.skip(-10);
                        } else if (e.key === 'f' || e.key === 'F') {
                            e.preventDefault();
                            this.toggleFullscreen();
                        } else if (e.key === 'm' || e.key === 'M') {
                            e.preventDefault();
                            this.toggleMute();
                        }
                    }
                 }"
                 @keydown.window="handleKeydown($event)">
                @if ($activeLesson && $activeLesson->video_url)
                    <div x-ref="playerAspect"
                         wire:key="player-aspect-{{ $activeLesson->id }}"
                         @mousemove="userActivity()"
                         @mouseleave="if (playing) showControls = false"
                         @touchstart="userActivity()"
                         class="relative w-full aspect-video bg-black overflow-hidden select-none group">
                        @if ($this->isLocalMedia)
                            @if (preg_match('/\.(mp3|wav|m4a)$/i', $activeLesson->video_url))
                                <!-- Audio Media Player UI -->
                                <div wire:key="audio-container-{{ $activeLesson->id }}" class="w-full h-full flex flex-col items-center justify-center p-8 bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 text-white space-y-6">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-[#D62828] to-orange-500 flex items-center justify-center shadow-lg shadow-red-500/20 animate-pulse">
                                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 .895-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 .895-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                        </svg>
                                    </div>
                                    <div class="text-center space-y-1">
                                        <span class="px-3 py-1 rounded-full bg-red-500/10 text-red-400 text-xs font-bold border border-red-500/20 uppercase tracking-wider">Audio Lesson</span>
                                        <h2 class="text-lg font-bold text-slate-100">{{ $activeLesson->title }}</h2>
                                    </div>
                                    <audio x-ref="videoPlayer"
                                           src="{{ $this->mediaUrl }}"
                                           wire:key="audio-player-{{ $activeLesson->id }}"
                                           controls
                                           autoplay
                                           class="w-full max-w-md rounded-lg shadow-md"
                                           preload="auto"
                                           @loadedmetadata="if ({{ (int)$watchTimeSeconds }} > 0 && {{ (int)$watchTimeSeconds }} < $el.duration) { $el.currentTime = {{ (int)$watchTimeSeconds }}; }">
                                        <source src="{{ $this->mediaUrl }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @else
                                <!-- HTML5 Video Player -->
                                <video x-ref="videoPlayer"
                                       src="{{ $this->mediaUrl }}"
                                       wire:key="video-player-{{ $activeLesson->id }}"
                                       wire:ignore.self
                                       class="w-full h-full object-contain block focus:outline-none cursor-pointer"
                                       autoplay
                                       preload="auto"
                                       playsinline
                                       controlsList="nodownload"
                                       @play="playing = true; userActivity()"
                                       @pause="playing = false; showControls = true"
                                       @loadedmetadata="
                                           duration = $el.duration || 0;
                                           if ({{ (int)$watchTimeSeconds }} > 0 && {{ (int)$watchTimeSeconds }} < $el.duration) {
                                               $el.currentTime = {{ (int)$watchTimeSeconds }};
                                           }
                                           currentTime = $el.currentTime || 0;
                                       "
                                       @timeupdate="
                                           if (!isSeeking) {
                                               currentTime = $el.currentTime || 0;
                                               duration = $el.duration || 0;
                                           }
                                       "
                                       @ended="playing = false; showControls = true; $wire.call('markAsComplete')"
                                       @click="togglePlay()">
                                    <source src="{{ $this->mediaUrl }}" type="video/mp4">
                                    Your browser does not support HTML5 video streaming.
                                </video>

                                <!-- Video Overlay Play Button (Center overlay when paused) -->
                                <div @click="togglePlay()"
                                     x-show="!playing"
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-90"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-90"
                                     class="absolute inset-0 flex items-center justify-center bg-black/30 pointer-events-auto z-20 cursor-pointer">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#D62828] text-white flex items-center justify-center shadow-2xl transform hover:scale-110 transition-transform">
                                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- ABSOLUTE BOTTOM CONTROLS BAR (Anchored strictly to bottom:0, left:0, right:0 of the video wrapper) -->
                                <div x-show="!playing || showControls"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-2"
                                     style="position: absolute; bottom: 0; left: 0; right: 0; z-index: 30;"
                                     class="bg-gradient-to-t from-black/95 via-black/70 to-transparent px-3 sm:px-5 pb-3 pt-8 space-y-2 pointer-events-auto">
                                    
                                    <!-- 1. Interactive Seek Timeline at top of control bar -->
                                    <div x-ref="progressBar"
                                         @pointerdown="startSeeking($event)"
                                         @mousedown="startSeeking($event)"
                                         @touchstart="startSeeking($event)"
                                         class="w-full h-3 flex items-center cursor-pointer group/bar relative touch-none py-1">
                                        <!-- Track Background -->
                                        <div class="w-full h-1 group-hover/bar:h-2 rounded-full bg-white/20 relative overflow-hidden transition-all">
                                            <!-- Played Fill -->
                                            <div class="h-full bg-[#D62828] rounded-full transition-all duration-75 relative"
                                                 :style="`width: ${isSeeking ? seekingPercent : (duration > 0 ? (currentTime / duration) * 100 : 0)}%`">
                                            </div>
                                        </div>
                                        <!-- Progress Thumb Handle -->
                                        <div class="absolute w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full bg-white shadow-lg border-2 border-[#D62828] transform -translate-x-1/2 transition-all duration-150"
                                             :class="isSeeking ? 'opacity-100 scale-125' : 'opacity-0 group-hover/bar:opacity-100'"
                                             :style="`left: ${isSeeking ? seekingPercent : (duration > 0 ? (currentTime / duration) * 100 : 0)}%`">
                                        </div>
                                    </div>

                                    <!-- 2. Controls Row: [Play] [-10s] [+10s] [Current Time / Duration] [Flexible Space] [Volume] [Volume Slider] [Fullscreen] -->
                                    <div class="flex items-center justify-between gap-2 text-white text-xs font-semibold">
                                        
                                        <!-- Left Group: Play, -10s, +10s, Timestamp -->
                                        <div class="flex items-center gap-1.5 sm:gap-3">
                                            <!-- Play / Pause Button -->
                                            <button type="button" @click.stop="togglePlay()" class="p-1.5 rounded-lg hover:bg-white/20 text-white transition cursor-pointer" :title="playing ? 'Pause (Space)' : 'Play (Space)'">
                                                <template x-if="playing">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                                </template>
                                                <template x-if="!playing">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                </template>
                                            </button>

                                            <!-- 10s Rewind Button -->
                                            <button type="button" @click.stop="skip(-10)" class="px-2 py-1 rounded-lg hover:bg-white/20 text-white transition cursor-pointer flex items-center gap-1 text-xs font-mono font-bold" title="Rewind 10s (Left Arrow / J)">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.334 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path>
                                                </svg>
                                                <span>-10s</span>
                                            </button>

                                            <!-- 10s Forward Button -->
                                            <button type="button" @click.stop="skip(10)" class="px-2 py-1 rounded-lg hover:bg-white/20 text-white transition cursor-pointer flex items-center gap-1 text-xs font-mono font-bold" title="Forward 10s (Right Arrow / L)">
                                                <span>+10s</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.934 12.8a1 1 0 000-1.6l-5.334-4A1 1 0 005 8v8a1 1 0 001.6.8l5.334-4zM19.934 12.8a1 1 0 000-1.6l-5.334-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.334-4z"></path>
                                                </svg>
                                            </button>

                                            <!-- Current Time / Duration Counter -->
                                            <div class="text-xs font-mono font-bold text-slate-100 whitespace-nowrap ml-1">
                                                <span x-text="formatTime(currentTime)">00:00</span>
                                                <span class="text-slate-400">/</span>
                                                <span x-text="formatTime(duration)" class="text-slate-400">00:00</span>
                                            </div>
                                        </div>

                                        <!-- Flexible Space -->
                                        <div class="flex-1"></div>

                                        <!-- Right Group: Volume Icon, Volume Slider, Fullscreen Button -->
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <!-- Volume / Mute Button -->
                                            <button type="button" @click.stop="toggleMute()" class="p-1.5 rounded-lg hover:bg-white/20 text-white transition cursor-pointer" title="Mute/Unmute (M)">
                                                <template x-if="muted || volume === 0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
                                                </template>
                                                <template x-if="!muted && volume > 0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                                                </template>
                                            </button>

                                            <!-- Volume Range Slider -->
                                            <input type="range" min="0" max="1" step="0.05" :value="muted ? 0 : volume"
                                                   @input="setVolume($event.target.value)"
                                                   class="w-16 sm:w-20 accent-[#D62828] cursor-pointer h-1.5 bg-slate-700 rounded-lg hidden sm:block">

                                            <!-- Fullscreen Button -->
                                            <button type="button" @click.stop="toggleFullscreen()" class="p-1.5 rounded-lg hover:bg-white/20 text-white transition cursor-pointer" title="Toggle Fullscreen (F)">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m4 0v4m0-4l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                                </svg>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @else
                            <!-- Embedded YouTube / External Video Player -->
                            <iframe wire:key="iframe-player-{{ $activeLesson->id }}"
                                    class="w-full h-full"
                                    src="{{ $this->embedUrl }}"
                                    title="{{ $activeLesson->title }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        @endif
                    </div>
                @else
                    <div class="aspect-video w-full bg-slate-950 flex flex-col items-center justify-center p-8 text-center text-white space-y-3">
                        <div class="text-4xl">🎬</div>
                        <h3 class="text-lg font-bold">Select a Lesson to Begin Streaming</h3>
                        <p class="text-xs text-slate-400 max-w-sm">Choose an unlocked lesson from the curriculum sidebar on the right.</p>
                    </div>
                @endif
            </div>

            <!-- Video Player Controls Bar (Previous, Mark Complete, Next Lesson) -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl shadow-xl flex flex-wrap items-center justify-between gap-3 text-white">
                <!-- Previous Lesson -->
                @if ($previousLesson)
                    <button type="button"
                            wire:click="selectLesson('{{ $previousLesson->id }}')"
                            class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs flex items-center gap-1.5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>Previous Lesson</span>
                    </button>
                @else
                    <button type="button" disabled class="px-4 py-2.5 rounded-xl bg-slate-900 text-slate-600 font-bold text-xs opacity-50 cursor-not-allowed">
                        Previous Lesson
                    </button>
                @endif

                <!-- Mark Complete & Resume Info -->
                <div class="flex items-center gap-2">
                    @if ($watchTimeSeconds > 0)
                        <span class="hidden sm:inline text-[11px] font-semibold text-slate-400">
                            Resume: <strong class="text-white">{{ gmdate('H:i:s', $watchTimeSeconds) }}</strong>
                        </span>
                    @endif

                    <button type="button"
                            wire:click="markAsComplete"
                            style="background-color: #D62828;"
                            class="px-5 py-2.5 rounded-xl font-black text-xs shadow-md transition-all flex items-center gap-2 text-white">
                        @if ($isCompleted)
                            <span>✓ Lesson Completed</span>
                        @else
                            <span>Mark Lesson Complete</span>
                        @endif
                    </button>

                    <button type="button" wire:click="toggleBookmark" class="p-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs" title="Add Bookmark">
                        🔖
                    </button>
                </div>

                <!-- Next Lesson / Continue Learning -->
                @if ($nextLesson)
                    @if ($isNextUnlocked)
                        <button type="button"
                                wire:click="selectLesson('{{ $nextLesson->id }}')"
                                style="background-color: #D62828;"
                                class="px-4 py-2.5 rounded-xl text-white font-black text-xs shadow-md transition-all flex items-center gap-1.5">
                            <span>Next Lesson</span>
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @else
                        <button type="button" disabled class="px-4 py-2.5 rounded-xl bg-slate-800 text-slate-500 font-bold text-xs cursor-not-allowed flex items-center gap-1.5" title="Complete current lesson to unlock">
                            <span>Next Lesson 🔒</span>
                        </button>
                    @endif
                @else
                    <a href="{{ route('student.courses.show', $course->id) }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-black text-xs shadow-md text-decoration-none">
                        Course Completed 🎉
                    </a>
                @endif
            </div>

            <!-- Player Tabs (Notes, Bookmarks, Resources, Review, Analytics) -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-6 text-white">
                <div class="border-b border-slate-800 flex items-center gap-6 overflow-x-auto">
                    <button wire:click="$set('activeTab', 'notes')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'notes' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
                        📝 Lesson Notes ({{ count($notes) }})
                    </button>
                    <button wire:click="$set('activeTab', 'bookmarks')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'bookmarks' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
                        🔖 Bookmarks ({{ count($bookmarks) }})
                    </button>
                    <button wire:click="$set('activeTab', 'resources')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'resources' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
                        📦 Downloads & Files ({{ count($resources) }})
                    </button>
                    <button wire:click="$set('activeTab', 'analytics')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'analytics' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
                        📊 Learning Analytics
                    </button>
                    <button wire:click="$set('activeTab', 'reviews')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'reviews' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
                        ⭐ Course Review
                    </button>
                </div>

                <!-- Tab 1: Timestamped Lesson Notes (Search, Create, Edit, Delete) -->
                @if ($activeTab === 'notes')
                    <div class="space-y-4">
                        <!-- Search Notes Input -->
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="noteSearch" placeholder="Search my notes..."
                                   style="background: #112240; border: 1px solid #1e3a5f; color: white;"
                                   class="w-full pl-9 pr-4 py-2 rounded-xl text-xs text-white placeholder-slate-400 focus:outline-none">
                            <div class="absolute left-3 top-2.5 text-slate-400">🔍</div>
                        </div>

                        <!-- Create Note Form -->
                        <form wire:submit="addNote" class="space-y-3">
                            <textarea wire:model="newNoteText" rows="3" placeholder="Type your personal note for this lesson..."
                                      style="background: #112240; border: 1px solid #1e3a5f; color: white;"
                                      class="w-full p-3 rounded-xl text-xs text-white focus:outline-none focus:border-rose-500"></textarea>
                            @error('newNoteText') <span class="text-[11px] text-rose-400 font-semibold">{{ $message }}</span> @enderror
                            
                            <div class="flex items-center justify-between">
                                <div class="text-[11px] text-slate-400 font-semibold">
                                    Timecode Anchor: <span class="text-white font-bold">{{ gmdate('H:i:s', $noteTimestamp) }}</span>
                                </div>
                                <button type="submit" style="background-color: #D62828;" class="px-4 py-2 rounded-xl text-white font-black text-xs shadow-sm">
                                    Save Note at Current Time
                                </button>
                            </div>
                        </form>

                        <!-- Edit Note Modal Form if Active -->
                        @if ($editingNoteId)
                            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-3 text-white">
                                <div class="text-xs font-bold text-amber-400">Edit Selected Note</div>
                                <textarea wire:model="editingNoteText" rows="2" style="background: #07162C; border: 1px solid #1e3a5f; color: white;" class="w-full p-2.5 rounded-xl text-xs focus:outline-none"></textarea>
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="$set('editingNoteId', null)" class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 font-bold text-xs">Cancel</button>
                                    <button wire:click="updateNote" style="background-color: #D62828;" class="px-3 py-1.5 rounded-lg text-white font-black text-xs">Save Edits</button>
                                </div>
                            </div>
                        @endif

                        <!-- Notes List -->
                        <div class="space-y-2 pt-2">
                            @forelse ($notes as $note)
                                <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl flex items-start justify-between gap-3 text-xs text-white">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded bg-[#D62828] text-white font-mono text-[10px] font-black">
                                                {{ gmdate('H:i:s', $note->timestamp_seconds) }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-semibold">{{ $note->lesson?->title }}</span>
                                        </div>
                                        <p class="text-slate-200 mt-1 font-medium leading-relaxed">{{ $note->note_text }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button wire:click="editNote('{{ $note->id }}', '{{ addslashes($note->note_text) }}')" class="text-blue-400 hover:underline text-[11px] font-bold">Edit</button>
                                        <button wire:click="deleteNote('{{ $note->id }}')" class="text-rose-400 hover:text-rose-600 text-xs font-bold">✕</button>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-xs text-slate-400 text-center">No notes found. Type a note above to save!</div>
                            @endforelse
                        </div>
                    </div>
                @elseif ($activeTab === 'bookmarks')
                    <div class="space-y-4">
                        <!-- Search Bookmarks Input -->
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="bookmarkSearch" placeholder="Search my bookmarks..."
                                   style="background: #112240; border: 1px solid #1e3a5f; color: white;"
                                   class="w-full pl-9 pr-4 py-2 rounded-xl text-xs text-white placeholder-slate-400 focus:outline-none">
                            <div class="absolute left-3 top-2.5 text-slate-400">🔍</div>
                        </div>

                        <div class="space-y-2">
                            @forelse ($bookmarks as $bm)
                                <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl flex items-center justify-between text-xs text-white">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-mono text-[10px] font-black border border-amber-500/30">
                                            {{ gmdate('H:i:s', $bm->timestamp_seconds) }}
                                        </span>
                                        <span class="font-bold text-white">{{ $bm->title }}</span>
                                    </div>
                                    <button wire:click="removeBookmark('{{ $bm->id }}')" class="text-rose-400 hover:text-rose-600 font-bold text-xs">Remove</button>
                                </div>
                            @empty
                                <div class="p-4 text-xs text-slate-400 text-center">No bookmarks found.</div>
                            @endforelse
                        </div>
                    </div>
                @elseif ($activeTab === 'resources')
                    <div class="space-y-3">
                        @forelse ($resources as $r)
                            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-white">
                                <div>
                                    <div class="font-bold text-white text-sm">{{ $r['title'] }}</div>
                                    <div class="text-slate-400 text-[11px] mt-0.5 flex items-center gap-3">
                                        <span>Size: <strong>{{ $r['file_size'] }}</strong></span>
                                        <span>•</span>
                                        <span>Version: <strong>{{ $r['version'] }}</strong></span>
                                        <span>•</span>
                                        <span>Downloads: <strong class="text-blue-400">{{ $r['download_count'] ?? 0 }}</strong></span>
                                    </div>
                                </div>
                                <button wire:click="downloadResource('{{ $r['id'] }}')"
                                        style="background-color: #D62828;"
                                        class="px-4 py-2 rounded-xl text-white font-black text-xs shadow-sm transition-all whitespace-nowrap">
                                    Download File
                                </button>
                            </div>
                        @empty
                            <div class="p-4 text-xs text-slate-400 text-center">No resources available for download.</div>
                        @endforelse
                    </div>
                @elseif ($activeTab === 'analytics')
                    <div class="space-y-4 text-xs">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-center text-white">
                                <div class="text-slate-400 font-bold uppercase text-[10px]">Overall Progress</div>
                                <div class="text-2xl font-black text-white mt-1">{{ $analytics['overall_progress'] ?? 0 }}%</div>
                            </div>
                            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-center text-white">
                                <div class="text-slate-400 font-bold uppercase text-[10px]">Course Progress</div>
                                <div class="text-2xl font-black text-[#D62828] mt-1">{{ $analytics['course_progress'] ?? 0 }}%</div>
                            </div>
                            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-center text-white">
                                <div class="text-slate-400 font-bold uppercase text-[10px]">Time Spent</div>
                                <div class="text-2xl font-black text-purple-400 mt-1">{{ $analytics['total_learning_hours'] ?? 0 }}h</div>
                            </div>
                            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-center text-white">
                                <div class="text-slate-400 font-bold uppercase text-[10px]">Remaining Time</div>
                                <div class="text-2xl font-black text-blue-400 mt-1">{{ $analytics['remaining_hours'] ?? 0 }}h</div>
                            </div>
                        </div>
                    </div>
                @elseif ($activeTab === 'reviews')
                    <form wire:submit="submitReview" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">Your Rating</label>
                            <select wire:model="reviewRating" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2 rounded-xl text-xs font-bold">
                                <option value="5" class="text-slate-900">⭐⭐⭐⭐⭐ (5/5) Excellent</option>
                                <option value="4" class="text-slate-900">⭐⭐⭐⭐ (4/5) Very Good</option>
                                <option value="3" class="text-slate-900">⭐⭐⭐ (3/5) Average</option>
                                <option value="2" class="text-slate-900">⭐⭐ (2/5) Poor</option>
                                <option value="1" class="text-slate-900">⭐ (1/5) Terrible</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">Written Review</label>
                            <textarea wire:model="reviewText" rows="3" placeholder="Write your feedback..."
                                      style="background: #112240; border: 1px solid #1e3a5f; color: white;"
                                      class="w-full p-3 rounded-xl text-xs focus:outline-none"></textarea>
                            @error('reviewText') <span class="text-[11px] text-rose-400 font-semibold">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white font-black text-xs shadow-md">
                            Submit Course Review
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Right 1 Column: Curriculum Accordion Sidebar -->
        <div class="space-y-4">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="text-base font-black text-white">Curriculum Syllabus</h3>
                </div>

                @php
                    $unlockedFlag = true;
                @endphp

                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-1">
                    @foreach ($modules as $mod)
                        <div x-data="{ open: true }" style="background: #112240; border: 1px solid #1e3a5f;" class="rounded-2xl overflow-hidden text-xs text-white">
                            <button @click="open = !open" class="w-full p-3 bg-slate-900/60 flex items-center justify-between font-black text-white">
                                <span class="truncate">{{ $mod->title }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" class="p-2 space-y-1">
                                @foreach ($mod->lessons as $les)
                                    @php
                                        $prog = $les->progress->first();
                                        $isDone = $prog?->is_completed ?? false;
                                        $isActive = ((string) $activeLesson?->id === (string) $les->id);
                                        $isUnlocked = true;
                                    @endphp

                                    @if ($isUnlocked)
                                        <button wire:click="selectLesson('{{ $les->id }}')"
                                                class="w-full text-left p-2.5 rounded-xl flex items-center justify-between transition-all {{ $isActive ? 'bg-[#D62828] text-white font-extrabold shadow-md' : 'hover:bg-white/10 text-slate-300' }}">
                                            <div class="flex items-center gap-2 truncate">
                                                @if ($isDone)
                                                    <span class="text-emerald-400 font-bold">✓</span>
                                                @elseif ($isActive)
                                                    <span class="text-white font-bold">▶</span>
                                                @endif
                                                <span class="truncate">{{ $les->title }}</span>
                                            </div>
                                            <span class="text-[10px] opacity-75 whitespace-nowrap">{{ (int) round($les->duration / 60) }}m</span>
                                        </button>
                                    @else
                                        <div class="p-2.5 rounded-xl flex items-center justify-between text-slate-500 bg-slate-900 opacity-60 cursor-not-allowed">
                                            <div class="flex items-center gap-2 truncate">
                                                <span>🔒</span>
                                                <span class="truncate">{{ $les->title }}</span>
                                            </div>
                                            <span class="text-[10px]">{{ (int) round($les->duration / 60) }}m</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
