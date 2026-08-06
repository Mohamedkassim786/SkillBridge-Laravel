<div class="space-y-8 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">Coding Practice Sandbox</h1>
            <p class="text-xs text-slate-300 mt-1">Solve real PHP 8.3 & Laravel algorithm challenges with instant test case execution.</p>
        </div>
        <button wire:click="runCode" style="background-color: #D62828;" class="px-6 py-3 text-white rounded-2xl text-xs font-black shadow-lg hover:bg-rose-700 transition flex items-center gap-2">
            ▶️ Run & Execute Code
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- LEFT COLUMN (PROBLEM STATEMENT & TESTS) -->
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        {{ $activeChallenge->difficulty ?? 'Easy' }}
                    </span>
                    <span class="text-xs font-bold text-slate-400">{{ $activeChallenge->category ?? 'Algorithms' }}</span>
                </div>

                <h3 class="font-black text-xl text-white leading-snug">{{ $activeChallenge->title ?? 'Two Sum' }}</h3>
                <p class="text-xs text-slate-300 leading-relaxed">{{ $activeChallenge->description }}</p>
            </div>

            <!-- TEST OUTPUT CONSOLE -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 text-white shadow-xl space-y-3">
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400">Execution Console Output</h4>
                <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl font-mono text-xs text-emerald-400 whitespace-pre-line min-h-[140px]">
                    {{ $executionOutput ?: 'Click "▶️ Run & Execute Code" to compile and evaluate test cases.' }}
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN (CODE EDITOR) -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="lg:col-span-2 rounded-3xl p-6 shadow-xl space-y-4 text-white">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <span class="text-xs font-black text-white">solution.php</span>
                <span class="text-[11px] font-bold text-slate-400">PHP 8.3 Runtime</span>
            </div>

            <textarea wire:model="userCode" rows="16" style="background: #112240; border: 1px solid #1e3a5f; color: #34d399;" class="w-full p-4 rounded-2xl font-mono text-xs focus:outline-none focus:border-rose-500 leading-relaxed"></textarea>
        </div>
    </div>
</div>