<div class="space-y-8" x-data="{ modalOpen: @entangle('showModal') }">
    <!-- Admin Header & Course Selector -->
    <div class="p-6 rounded-3xl bg-gradient-to-r from-[#0B1F3A] to-slate-900 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-widest">
                <span>SkillBridge Admin Portal</span>
                <span>•</span>
                <span class="text-[#D62828]">Video & Curriculum Manager</span>
            </div>
            <h1 class="text-2xl font-extrabold text-white mt-1">Manage Course Lessons & Video Content</h1>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">Upload video/audio media files or assign YouTube URLs to lessons. Uploaded files automatically land in storage/videos and become visible to students.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <select wire:model.live="selectedCourseId" class="px-4 py-2.5 rounded-xl bg-slate-800 text-white text-xs font-bold border border-slate-700 focus:ring-2 focus:ring-[#D62828] outline-none">
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>

            <button wire:click="openCreateModal" class="px-5 py-2.5 rounded-xl bg-[#D62828] hover:bg-red-700 text-white text-xs font-extrabold shadow-lg flex items-center gap-2 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Upload & Add Lesson</span>
            </button>
        </div>
    </div>

    <!-- Course Modules & Lessons List -->
    @if ($selectedCourse)
        <div class="space-y-6">
            @forelse ($modules as $module)
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h2 class="text-base font-extrabold text-[#0B1F3A] flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#D62828]"></span>
                            <span>{{ $module->title }}</span>
                        </h2>
                        <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                            {{ $module->lessons->count() }} {{ Str::plural('Lesson', $module->lessons->count()) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        @forelse ($module->lessons->sortBy('sort_order') as $lesson)
                            <div class="p-4 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all">
                                <div class="flex items-start sm:items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-lg font-bold text-[#0B1F3A] shadow-xs">
                                        🎬
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                            <span>{{ $lesson->title }}</span>
                                            @if ($lesson->is_free_preview)
                                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">Free Preview</span>
                                            @endif
                                        </h3>
                                        <div class="flex items-center gap-3 text-xs text-slate-500 mt-0.5">
                                            <span>Duration: {{ gmdate('i:s', $lesson->duration) }}</span>
                                            <span>•</span>
                                            <span class="truncate max-w-xs font-mono text-[11px] text-slate-600 bg-white px-2 py-0.5 rounded border border-slate-200">
                                                {{ $lesson->video_url }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 self-end sm:self-center">
                                    <a href="{{ route('student.courses.player', ['courseId' => $selectedCourse->id, 'lesson' => $lesson->id]) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition-all">
                                        Preview Player ↗
                                    </a>

                                    <button wire:click="editLesson('{{ $lesson->id }}')" class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-all">
                                        Edit
                                    </button>

                                    <button wire:click="deleteLesson('{{ $lesson->id }}')" wire:confirm="Are you sure you want to delete this lesson?" class="px-3 py-1.5 rounded-xl bg-red-100 hover:bg-red-200 text-red-700 font-bold text-xs transition-all">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 rounded-xl bg-slate-100 text-slate-500 text-xs font-medium text-center">
                                No lessons added to this module yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="p-8 rounded-3xl bg-white border border-slate-200 text-center text-slate-500">
                    No modules found for this course.
                </div>
            @endforelse
        </div>
    @endif

    <!-- Upload / Edit Modal -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-xl rounded-3xl bg-white p-6 sm:p-8 shadow-2xl space-y-6" @click.away="modalOpen = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-extrabold text-[#0B1F3A]">
                    {{ $editingLessonId ? 'Edit Lesson & Video' : 'Add New Lesson & Video' }}
                </h3>
                <button @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">✕</button>
            </div>

            <form wire:submit.prevent="saveLesson" class="space-y-4">
                <!-- Module Selection -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Module</label>
                    <select wire:model="module_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-[#D62828]">
                        @foreach ($modules as $mod)
                            <option value="{{ $mod->id }}">{{ $mod->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Lesson Title -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Lesson Title</label>
                    <input type="text" wire:model="title" placeholder="e.g. Introduction to MVC" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-[#D62828]">
                    @error('title') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Option A: File Upload -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-dashed border-slate-300 space-y-2">
                    <label class="block text-xs font-bold text-[#0B1F3A] uppercase">Option 1: Upload Video / Media File (.mp4, .mp3, .webm)</label>
                    <input type="file" wire:model="videoFile" class="text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0B1F3A] file:text-white hover:file:bg-slate-800">
                    <p class="text-[11px] text-slate-400">Uploaded file will be saved directly into <code class="bg-slate-200 text-slate-800 px-1 rounded">storage/app/public/videos</code></p>
                    @error('videoFile') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Option B: Direct URL / YouTube -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Option 2: Video URL or Local Storage Path</label>
                    <input type="text" wire:model="video_url" placeholder="storage/videos/sample.mp4 OR https://www.youtube.com/watch?v=..." class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono focus:ring-2 focus:ring-[#D62828]">
                    @error('video_url') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Duration -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Duration (Seconds)</label>
                        <input type="number" wire:model="duration" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-[#D62828]">
                    </div>

                    <!-- Free Preview Checkbox -->
                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_free_preview" class="rounded border-slate-300 text-[#D62828] focus:ring-[#D62828] w-4 h-4">
                            <span class="text-xs font-bold text-slate-700">Free Preview Lesson</span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#D62828] hover:bg-red-700 text-white text-xs font-extrabold shadow-md">
                        Save Lesson & Video
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
