<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-base font-black text-white">⚡ Quick Shortcuts</h3>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        <a href="{{ route('student.courses.index') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none">
            <div class="text-lg mb-1 group-hover:scale-110 transition-transform">▶️</div>
            <div class="text-xs font-extrabold">Resume Lesson</div>
        </a>

        <a href="{{ route('courses.index') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none">
            <div class="text-lg mb-1 group-hover:scale-110 transition-transform">📚</div>
            <div class="text-xs font-extrabold">Browse Courses</div>
        </a>

        <a href="{{ route('jobs.index') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none">
            <div class="text-lg mb-1 group-hover:scale-110 transition-transform">💼</div>
            <div class="text-xs font-extrabold">Search Jobs</div>
        </a>

        <a href="{{ route('student.career.resume') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none">
            <div class="text-lg mb-1 group-hover:scale-110 transition-transform">📄</div>
            <div class="text-xs font-extrabold">Resume Builder</div>
        </a>

        <a href="{{ route('student.practice.coding') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none">
            <div class="text-lg mb-1 group-hover:scale-110 transition-transform">🤖</div>
            <div class="text-xs font-extrabold">Practice Sandbox</div>
        </a>

        <a href="{{ route('student.certificates.index') }}" style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl hover:bg-rose-600 transition-all text-center group text-white text-decoration-none">
            <div class="text-lg mb-1 group-hover:scale-110 transition-transform">📜</div>
            <div class="text-xs font-extrabold">Download Cert</div>
        </a>
    </div>
</div>
