<div class="min-h-screen">

    {{-- Blog List Header --}}
    <div class="relative bg-[#07101F] border-b border-white/5 py-16 overflow-hidden">
        <div class="absolute inset-0 dot-grid opacity-20 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <span class="text-xs font-bold text-rose-500 uppercase tracking-[0.2em]">Engineering Deep-Dives</span>
            <h1 class="text-4xl font-black text-white tracking-tight mt-2 mb-3">Software Engineering <span class="gradient-text-red">Blog</span></h1>
            <p class="text-slate-400 max-w-xl">Architecture articles, Laravel 12 tutorials, system design patterns, and production engineering best practices.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="group glass-card border-glow rounded-3xl overflow-hidden hover-lift flex flex-col">
                    <div class="h-1.5 bg-gradient-to-r from-violet-600 via-purple-500 to-rose-500"></div>
                    <div class="p-6 flex flex-col gap-4 flex-1">
                        <span class="px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-400 text-[10px] font-bold uppercase w-fit">
                            {{ $post->category }}
                        </span>

                        <h3 class="text-base font-bold text-white group-hover:text-rose-400 transition-colors leading-snug flex-1">
                            {{ $post->title }}
                        </h3>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $post->excerpt }}</p>

                        <div class="pt-4 border-t border-white/5 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-violet-500 to-rose-400 flex items-center justify-center text-white font-bold text-[9px]">
                                    {{ strtoupper(substr($post->author_name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="text-xs text-slate-500">{{ $post->author_name }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <span>⏱ {{ $post->read_time_mins }}m</span>
                                <span>·</span>
                                <span>{{ number_format($post->views_count) }} views</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-slate-600 py-20">No blog posts published yet.</div>
            @endforelse
        </div>
    </div>
</div>
