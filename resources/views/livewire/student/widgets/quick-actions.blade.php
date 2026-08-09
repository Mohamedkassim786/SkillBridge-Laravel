<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-base font-black text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>Quick Shortcuts</span>
        </h3>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        <a href="{{ route('student.courses.index') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none flex flex-col items-center justify-center">
            <div class="mb-1.5 group-hover:scale-110 transition-transform text-rose-400 group-hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-xs font-extrabold">Resume Lesson</div>
        </a>

        <a href="{{ route('courses.index') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none flex flex-col items-center justify-center">
            <div class="mb-1.5 group-hover:scale-110 transition-transform text-blue-400 group-hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div class="text-xs font-extrabold">Browse Courses</div>
        </a>

        <a href="{{ route('jobs.index') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none flex flex-col items-center justify-center">
            <div class="mb-1.5 group-hover:scale-110 transition-transform text-emerald-400 group-hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div class="text-xs font-extrabold">Search Jobs</div>
        </a>

        <a href="{{ route('student.career.resume') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none flex flex-col items-center justify-center">
            <div class="mb-1.5 group-hover:scale-110 transition-transform text-indigo-400 group-hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="text-xs font-extrabold">Resume Builder</div>
        </a>

        <a href="{{ route('student.practice.coding') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none flex flex-col items-center justify-center">
            <div class="mb-1.5 group-hover:scale-110 transition-transform text-purple-400 group-hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
            </div>
            <div class="text-xs font-extrabold">Practice Sandbox</div>
        </a>

        <a href="{{ route('student.certificates.index') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none flex flex-col items-center justify-center">
            <div class="mb-1.5 group-hover:scale-110 transition-transform text-amber-400 group-hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <div class="text-xs font-extrabold">Download Cert</div>
        </a>
    </div>
</div>
