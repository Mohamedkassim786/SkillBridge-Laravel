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
        <div class="lg:col-span-2 space-y-6">
            <!-- Video/Media Player Container -->
            <div class="rounded-3xl bg-black overflow-hidden shadow-2xl border border-slate-800 relative"
                 x-data="{
                    playing: true,
                    currentTime: 0,
                    getVideo() {
                        return this.$el.querySelector('video') || this.$el.querySelector('audio') || this.$refs.videoPlayer;
                    },
                    togglePlay() {
                        let v = this.getVideo();
                        if (!v) return;
                        if (v.paused) {
                            v.play();
                            this.playing = true;
                        } else {
                            v.pause();
                            this.playing = false;
                        }
                    },
                    skip(seconds) {
                        let v = this.getVideo();
                        if (!v) return;
                        v.currentTime = Math.max(0, Math.min(v.duration || 0, v.currentTime + seconds));
                    },
                    handleKeydown(e) {
                        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) return;

                        if (e.code === 'Space' || e.key === 'k' || e.key === 'K') {
                            e.preventDefault();
                            this.togglePlay();
                        } else if (e.key === 'ArrowRight' || e.key === 'l' || e.key === 'L') {
                            e.preventDefault();
                            this.skip(5);
                        } else if (e.key === 'ArrowLeft' || e.key === 'j' || e.key === 'J') {
                            e.preventDefault();
                            this.skip(-5);
                        } else if (e.key === 'f' || e.key === 'F') {
                            e.preventDefault();
                            let v = this.getVideo();
                            if (v) {
                                if (document.fullscreenElement) document.exitFullscreen();
                                else if (v.requestFullscreen) v.requestFullscreen();
                            }
                        }
                    }
                 }"
                 @keydown.window="handleKeydown($event)">
                @if ($activeLesson && $activeLesson->video_url)
                    <div wire:key="player-aspect-{{ $activeLesson->id }}" class="aspect-video w-full bg-black relative flex items-center justify-center group">
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
                                       class="w-full h-full object-contain focus:outline-none relative z-10"
                                       controls
                                       autoplay
                                       preload="auto"
                                       controlsList="nodownload"
                                       @play="playing = true"
                                       @pause="playing = false"
                                       @loadedmetadata="if ({{ (int)$watchTimeSeconds }} > 0 && {{ (int)$watchTimeSeconds }} < $el.duration) { $el.currentTime = {{ (int)$watchTimeSeconds }}; }"
                                       @timeupdate="currentTime = Math.floor($el.currentTime)"
                                       @ended="playing = false; $wire.call('markAsComplete')">
                                    <source src="{{ $this->mediaUrl }}" type="video/mp4">
                                    Your browser does not support HTML5 video streaming.
                                </video>
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
