<x-layouts.staff>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-white">Schedule Jitsi Live Masterclass</h1>
                <p class="text-xs text-slate-300 mt-1">Configure class parameters, select assigned course/batch, and generate Jitsi meeting room.</p>
            </div>
            <a href="{{ route('staff.live-classes.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 text-slate-300 font-bold text-xs text-decoration-none">
                ← Back to Classes
            </a>
        </div>
    </x-slot>

    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="max-w-3xl mx-auto rounded-3xl p-8 shadow-xl text-white space-y-6">
        <form method="POST" action="{{ route('staff.live-classes.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Masterclass Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g., Domain-Driven Architecture & Repository Pattern" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-2xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                @error('title') <span class="text-[11px] text-rose-400 font-semibold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Select Course *</label>
                    <select name="course_id" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-2xl text-xs font-bold focus:outline-none">
                        <option value="" class="text-slate-900">Choose Course</option>
                        @foreach ($courses as $c)
                            <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }} class="text-slate-900">{{ $c->title }}</option>
                        @endforeach
                    </select>
                    @error('course_id') <span class="text-[11px] text-rose-400 font-semibold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Select Batch (Optional)</label>
                    <select name="batch_id" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-2xl text-xs font-bold focus:outline-none">
                        <option value="" class="text-slate-900">All Students Enrolled in Course</option>
                        @foreach ($batches as $b)
                            <option value="{{ $b->id }}" {{ old('batch_id') == $b->id ? 'selected' : '' }} class="text-slate-900">{{ $b->name }} ({{ $b->courseVersion?->course?->title }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Class Description & Agenda</label>
                <textarea name="description" rows="4" placeholder="Briefly describe what topics will be covered in this live session..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full p-4 rounded-2xl text-xs font-semibold focus:outline-none focus:border-rose-500">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Date *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-2xl text-xs font-bold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Start Time *</label>
                    <input type="time" name="start_time" value="{{ old('start_time', '18:00') }}" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-2xl text-xs font-bold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Duration (Minutes) *</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', 60) }}" min="15" max="480" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-2xl text-xs font-bold focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <label style="background: #112240; border: 1px solid #1e3a5f;" class="flex items-center gap-3 p-4 rounded-2xl cursor-pointer text-xs font-bold text-white">
                    <input type="checkbox" name="attendance_required" value="1" checked class="w-4 h-4 text-rose-600 rounded">
                    <span>Require Student Attendance Tracking</span>
                </label>

                <label style="background: #112240; border: 1px solid #1e3a5f;" class="flex items-center gap-3 p-4 rounded-2xl cursor-pointer text-xs font-bold text-white">
                    <input type="checkbox" name="recording_enabled" value="1" checked class="w-4 h-4 text-rose-600 rounded">
                    <span>Enable Session Recording Upload</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('staff.live-classes.index') }}" class="px-5 py-3 rounded-2xl bg-slate-800 text-slate-300 text-xs font-bold text-decoration-none">
                    Cancel
                </a>
                <button type="submit" style="background-color: #D62828;" class="px-6 py-3 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition">
                    🚀 Create & Generate Jitsi Room
                </button>
            </div>
        </form>
    </div>
</x-layouts.staff>
