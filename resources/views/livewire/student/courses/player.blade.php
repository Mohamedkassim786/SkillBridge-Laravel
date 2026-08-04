<div class="space-y-6">
    <!-- Top Breadcrumb & Course Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                <a href="{{ route('student.courses.index') }}" class="hover:text-[#D62828]">My Courses</a>
                <span>/</span>
                <a href="{{ route('student.courses.show', $course->id) }}" class="hover:text-[#D62828]">{{ $course->title }}</a>
            </div>
            <h1 class="text-xl font-extrabold text-[#0B1F3A] mt-1 flex items-center gap-3">
                <span>{{ $activeLesson?->title ?? 'Select a Lesson' }}</span>
                @if ($isCompleted)
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold border border-emerald-200">✓ Completed</span>
                @endif
            </h1>
        </div>

        <a href="{{ route('student.courses.show', $course->id) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs">
            Back to Course Syllabus
        </a>
    </div>

    <!-- Main Player Split Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left 2 Columns: Video Player & Controls -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Embedded YouTube Video Player Container -->
            <div class="rounded-3xl bg-slate-950 overflow-hidden shadow-2xl border border-slate-800 relative">
                @if ($activeLesson && $activeLesson->video_url)
                    <div class="aspect-video w-full bg-black relative">
                        <iframe class="w-full h-full"
                                src="{{ $this->embedUrl }}"
                                title="{{ $activeLesson->title }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
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
            <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-wrap items-center justify-between gap-3">
                <!-- Previous Lesson -->
                @if ($previousLesson)
                    <button wire:click="selectLesson('{{ $previousLesson->id }}')"
                            class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center gap-1.5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>Previous Lesson</span>
                    </button>
                @else
                    <button disabled class="px-4 py-2.5 rounded-xl bg-slate-50 text-slate-300 font-bold text-xs opacity-50 cursor-not-allowed">
                        Previous Lesson
                    </button>
                @endif

                <!-- Mark Complete & Resume Info -->
                <div class="flex items-center gap-2">
                    @if ($watchTimeSeconds > 0)
                        <span class="hidden sm:inline text-[11px] font-semibold text-slate-500">
                            Resume: <strong class="text-slate-800">{{ gmdate('H:i:s', $watchTimeSeconds) }}</strong>
                        </span>
                    @endif

                    <button wire:click="markAsComplete"
                            class="px-5 py-2.5 rounded-xl font-bold text-xs shadow-md transition-all flex items-center gap-2 {{ $isCompleted ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-[#D62828] hover:bg-[#b7102a] text-white' }}">
                        @if ($isCompleted)
                            <span>✓ Lesson Completed</span>
                        @else
                            <span>Mark Lesson Complete</span>
                        @endif
                    </button>

                    <button wire:click="toggleBookmark" class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs" title="Add Bookmark">
                        🔖
                    </button>
                </div>

                <!-- Next Lesson / Continue Learning -->
                @if ($nextLesson)
                    @if ($isNextUnlocked)
                        <button wire:click="selectLesson('{{ $nextLesson->id }}')"
                                class="px-4 py-2.5 rounded-xl bg-[#0B1F3A] hover:bg-slate-900 text-white font-bold text-xs shadow-md transition-all flex items-center gap-1.5">
                            <span>Next Lesson</span>
                            <svg class="w-4 h-4 text-[#D62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @else
                        <button disabled class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-400 font-bold text-xs cursor-not-allowed flex items-center gap-1.5" title="Complete current lesson to unlock">
                            <span>Next Lesson 🔒</span>
                        </button>
                    @endif
                @else
                    <a href="{{ route('student.courses.show', $course->id) }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs shadow-md">
                        Course Completed 🎉
                    </a>
                @endif
            </div>

            <!-- Player Tabs (Notes, Bookmarks, Resources, Review, Analytics) -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-6">
                <div class="border-b border-slate-200 flex items-center gap-6 overflow-x-auto">
                    <button wire:click="$set('activeTab', 'notes')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'notes' ? 'border-[#D62828] text-[#0B1F3A]' : 'border-transparent text-slate-400 hover:text-slate-700' }}">
                        📝 Lesson Notes ({{ count($notes) }})
                    </button>
                    <button wire:click="$set('activeTab', 'bookmarks')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'bookmarks' ? 'border-[#D62828] text-[#0B1F3A]' : 'border-transparent text-slate-400 hover:text-slate-700' }}">
                        🔖 Bookmarks ({{ count($bookmarks) }})
                    </button>
                    <button wire:click="$set('activeTab', 'resources')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'resources' ? 'border-[#D62828] text-[#0B1F3A]' : 'border-transparent text-slate-400 hover:text-slate-700' }}">
                        📦 Downloads & Files ({{ count($resources) }})
                    </button>
                    <button wire:click="$set('activeTab', 'analytics')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'analytics' ? 'border-[#D62828] text-[#0B1F3A]' : 'border-transparent text-slate-400 hover:text-slate-700' }}">
                        📊 Learning Analytics
                    </button>
                    <button wire:click="$set('activeTab', 'reviews')"
                            class="pb-3 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'reviews' ? 'border-[#D62828] text-[#0B1F3A]' : 'border-transparent text-slate-400 hover:text-slate-700' }}">
                        ⭐ Course Review
                    </button>
                </div>

                <!-- Tab 1: Timestamped Lesson Notes (Search, Create, Edit, Delete) -->
                @if ($activeTab === 'notes')
                    <div class="space-y-4">
                        <!-- Search Notes Input -->
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="noteSearch" placeholder="Search my notes..."
                                   class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none">
                            <div class="absolute left-3 top-2.5 text-slate-400">🔍</div>
                        </div>

                        <!-- Create Note Form -->
                        <form wire:submit="addNote" class="space-y-3">
                            <textarea wire:model="newNoteText" rows="3" placeholder="Type your personal note for this lesson..."
                                      class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#D62828]/30"></textarea>
                            @error('newNoteText') <span class="text-[11px] text-rose-600 font-semibold">{{ $message }}</span> @enderror
                            
                            <div class="flex items-center justify-between">
                                <div class="text-[11px] text-slate-500 font-semibold">
                                    Timecode Anchor: <span class="text-[#0B1F3A] font-bold">{{ gmdate('H:i:s', $noteTimestamp) }}</span>
                                </div>
                                <button type="submit" class="px-4 py-2 rounded-xl bg-[#0B1F3A] hover:bg-slate-900 text-white font-bold text-xs shadow-sm">
                                    Save Note at Current Time
                                </button>
                            </div>
                        </form>

                        <!-- Edit Note Modal Form if Active -->
                        @if ($editingNoteId)
                            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-3">
                                <div class="text-xs font-bold text-amber-900">Edit Selected Note</div>
                                <textarea wire:model="editingNoteText" rows="2" class="w-full p-2.5 rounded-xl bg-white border border-amber-300 text-xs text-slate-800 focus:outline-none"></textarea>
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="$set('editingNoteId', null)" class="px-3 py-1.5 rounded-lg bg-slate-200 text-slate-700 font-bold text-xs">Cancel</button>
                                    <button wire:click="updateNote" class="px-3 py-1.5 rounded-lg bg-[#0B1F3A] text-white font-bold text-xs">Save Edits</button>
                                </div>
                            </div>
                        @endif

                        <!-- Notes List -->
                        <div class="space-y-2 pt-2">
                            @forelse ($notes as $note)
                                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start justify-between gap-3 text-xs">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded bg-[#0B1F3A] text-white font-mono text-[10px] font-bold">
                                                {{ gmdate('H:i:s', $note->timestamp_seconds) }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-semibold">{{ $note->lesson?->title }}</span>
                                        </div>
                                        <p class="text-slate-700 mt-1 font-medium leading-relaxed">{{ $note->note_text }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button wire:click="editNote('{{ $note->id }}', '{{ addslashes($note->note_text) }}')" class="text-blue-600 hover:underline text-[11px] font-bold">Edit</button>
                                        <button wire:click="deleteNote('{{ $note->id }}')" class="text-rose-500 hover:text-rose-700 text-xs font-bold">✕</button>
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
                                   class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none">
                            <div class="absolute left-3 top-2.5 text-slate-400">🔍</div>
                        </div>

                        <div class="space-y-2">
                            @forelse ($bookmarks as $bm)
                                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 font-mono text-[10px] font-bold">
                                            {{ gmdate('H:i:s', $bm->timestamp_seconds) }}
                                        </span>
                                        <span class="font-bold text-[#0B1F3A]">{{ $bm->title }}</span>
                                    </div>
                                    <button wire:click="removeBookmark('{{ $bm->id }}')" class="text-rose-500 hover:text-rose-700 font-bold text-xs">Remove</button>
                                </div>
                            @empty
                                <div class="p-4 text-xs text-slate-400 text-center">No bookmarks found.</div>
                            @endforelse
                        </div>
                    </div>
                @elseif ($activeTab === 'resources')
                    <div class="space-y-3">
                        @forelse ($resources as $r)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                                <div>
                                    <div class="font-bold text-[#0B1F3A] text-sm">{{ $r['title'] }}</div>
                                    <div class="text-slate-500 text-[11px] mt-0.5 flex items-center gap-3">
                                        <span>Size: <strong>{{ $r['file_size'] }}</strong></span>
                                        <span>•</span>
                                        <span>Version: <strong>{{ $r['version'] }}</strong></span>
                                        <span>•</span>
                                        <span>Downloads: <strong class="text-blue-600">{{ $r['download_count'] ?? 0 }}</strong></span>
                                    </div>
                                </div>
                                <button wire:click="downloadResource('{{ $r['id'] }}')"
                                        class="px-4 py-2 rounded-xl bg-[#0B1F3A] hover:bg-slate-900 text-white font-bold text-xs shadow-sm transition-all whitespace-nowrap">
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
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                                <div class="text-slate-500 font-bold uppercase text-[10px]">Overall Progress</div>
                                <div class="text-2xl font-black text-[#0B1F3A] mt-1">{{ $analytics['overall_progress'] ?? 0 }}%</div>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                                <div class="text-slate-500 font-bold uppercase text-[10px]">Course Progress</div>
                                <div class="text-2xl font-black text-[#D62828] mt-1">{{ $analytics['course_progress'] ?? 0 }}%</div>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                                <div class="text-slate-500 font-bold uppercase text-[10px]">Time Spent</div>
                                <div class="text-2xl font-black text-purple-600 mt-1">{{ $analytics['total_learning_hours'] ?? 0 }}h</div>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                                <div class="text-slate-500 font-bold uppercase text-[10px]">Remaining Time</div>
                                <div class="text-2xl font-black text-blue-600 mt-1">{{ $analytics['remaining_hours'] ?? 0 }}h</div>
                            </div>
                        </div>
                    </div>
                @elseif ($activeTab === 'reviews')
                    <form wire:submit="submitReview" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Your Rating</label>
                            <select wire:model="reviewRating" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700">
                                <option value="5">⭐⭐⭐⭐⭐ (5/5) Excellent</option>
                                <option value="4">⭐⭐⭐⭐ (4/5) Very Good</option>
                                <option value="3">⭐⭐⭐ (3/5) Average</option>
                                <option value="2">⭐⭐ (2/5) Poor</option>
                                <option value="1">⭐ (1/5) Terrible</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Written Review</label>
                            <textarea wire:model="reviewText" rows="3" placeholder="Write your feedback..."
                                      class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:outline-none"></textarea>
                            @error('reviewText') <span class="text-[11px] text-rose-600 font-semibold">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#D62828] text-white font-bold text-xs shadow-md">
                            Submit Course Review
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Right 1 Column: Curriculum Accordion Sidebar -->
        <div class="space-y-4">
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="text-base font-extrabold text-[#0B1F3A]">Curriculum Syllabus</h3>
                </div>

                @php
                    $unlockedFlag = true;
                @endphp

                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-1">
                    @foreach ($modules as $mod)
                        <div x-data="{ open: true }" class="rounded-2xl border border-slate-200 overflow-hidden text-xs">
                            <button @click="open = !open" class="w-full p-3 bg-slate-50 flex items-center justify-between font-extrabold text-[#0B1F3A]">
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
                                        $isActive = ($activeLesson?->id === $les->id);
                                        $isUnlocked = $unlockedFlag;

                                        if (!$isDone && ($prog?->watch_percentage ?? 0) < 90) {
                                            $unlockedFlag = false;
                                        }
                                    @endphp

                                    @if ($isUnlocked)
                                        <button wire:click="selectLesson('{{ $les->id }}')"
                                                class="w-full text-left p-2.5 rounded-xl flex items-center justify-between transition-all {{ $isActive ? 'bg-[#0B1F3A] text-white font-bold shadow-md' : 'hover:bg-slate-100 text-slate-700' }}">
                                            <div class="flex items-center gap-2 truncate">
                                                @if ($isDone)
                                                    <span class="text-emerald-500 font-bold">✓</span>
                                                @elseif ($isActive)
                                                    <span class="text-[#D62828] font-bold">▶</span>
                                                @endif
                                                <span class="truncate">{{ $les->title }}</span>
                                            </div>
                                            <span class="text-[10px] opacity-75 whitespace-nowrap">{{ (int) round($les->duration / 60) }}m</span>
                                        </button>
                                    @else
                                        <div class="p-2.5 rounded-xl flex items-center justify-between text-slate-400 bg-slate-50 opacity-60 cursor-not-allowed">
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
