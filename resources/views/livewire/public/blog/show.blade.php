<div class="min-h-screen">

    {{-- Article Header --}}
    <div class="relative bg-[#07101F] border-b border-white/5 py-20 overflow-hidden">
        <div class="absolute inset-0 dot-grid opacity-20 pointer-events-none"></div>
        <div class="absolute right-0 top-0 w-96 h-96 bg-violet-600/6 blur-3xl rounded-full pointer-events-none"></div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative space-y-6">
            <div class="flex items-center gap-3 text-xs">
                <a href="{{ route('blog.index') }}" class="text-slate-500 hover:text-rose-400 transition-colors">Blog</a>
                <span class="text-slate-700">/</span>
                <span class="px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-400 font-bold uppercase">{{ $post->category }}</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight">{{ $post->title }}</h1>
            <div class="flex flex-wrap items-center gap-5 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-violet-500 to-rose-400 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr($post->author_name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="font-semibold text-slate-400">{{ $post->author_name }}</span>
                </div>
                <span>⏱ {{ $post->read_time_mins }} min read</span>
                <span>👁 {{ number_format($post->views_count) }} views</span>
                <span>{{ $post->created_at?->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Article Body --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card border border-white/8 rounded-3xl p-8 sm:p-12 space-y-8 prose prose-invert prose-slate max-w-none">
            <p class="text-lg text-slate-200 leading-relaxed font-medium border-l-4 border-rose-500 pl-6 italic">
                {{ $post->excerpt }}
            </p>
            <div class="text-slate-400 leading-relaxed whitespace-pre-line text-sm sm:text-base">
                {{ $post->content }}
            </div>
        </div>

        <div class="mt-10 pt-8 border-t border-white/5 flex items-center justify-between">
            <a href="{{ route('blog.index') }}" class="flex items-center gap-2 text-sm text-slate-500 hover:text-white transition-colors font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Blog
            </a>
            <a href="{{ route('courses.index') }}" class="btn-glow px-5 py-2.5 rounded-xl text-white text-sm font-bold">
                View Courses →
            </a>
        </div>
    </div>
</div>
