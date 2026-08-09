<div class="space-y-8 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-rose-400 uppercase tracking-widest mb-1">
                <span>🧠 NVIDIA Nim AI (Llama 3.3 70B) + RAG Engine</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">AI ATS Resume Builder & PDF Generator</h1>
            <p class="text-xs text-slate-300 mt-1">Enter your details. Click ✨ Suggestions to analyze fields, or Generate to auto-download the ATS PDF.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('student.career.resume.download-pdf') }}" target="_blank" style="background-color: #D62828;" class="px-6 py-3.5 text-white rounded-2xl text-xs font-black shadow-lg transition-all flex items-center gap-2 text-decoration-none hover:opacity-90">
                <span>⬇️ Download ATS Resume PDF</span>
            </a>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="p-4 rounded-2xl bg-rose-500/20 text-rose-300 border border-rose-500/40 text-xs font-bold flex items-center gap-2">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if (session()->has('status'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold flex items-center gap-2">
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- LEFT COLUMN: FULL INPUT FORM WITH INLINE AI CARDS (5 COLUMNS) -->
        <div class="lg:col-span-5 space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-black text-white flex items-center gap-2">
                        <span>📝 Candidate Information Form</span>
                    </h3>
                    <span class="text-[10px] text-slate-400 font-semibold">* Required fields</span>
                </div>

                <div class="space-y-5">
                    <!-- FULL NAME -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">
                            Full Name <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" wire:model.live.debounce.300ms="fullName" placeholder="e.g. Rafeeq Ahamed" style="background: #112240; border: {{ in_array('Full Name', $missingRequiredFields) ? '2px solid #ef4444' : '1px solid #1e3a5f' }}; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        
                        <!-- INLINE SUGGESTION CARD FOR FULL NAME -->
                        @if (isset($fieldSuggestions['fullName']) && $fieldSuggestions['fullName']['can_apply'])
                            <div class="mt-2.5 p-3.5 rounded-2xl bg-indigo-500/10 border border-indigo-500/40 text-xs space-y-2 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-md bg-indigo-500/20 text-indigo-300 font-black text-[10px] uppercase tracking-wider">✨ {{ $fieldSuggestions['fullName']['title'] ?? 'Name Capitalization' }}</span>
                                    <span class="text-[10px] font-bold text-indigo-200 uppercase">INFO</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">{{ $fieldSuggestions['fullName']['reason'] }}</p>
                                <div class="p-2.5 rounded-xl bg-slate-900/90 text-indigo-300 font-mono text-[11px] leading-relaxed whitespace-pre-line border border-indigo-500/20">{{ $fieldSuggestions['fullName']['suggested'] }}</div>
                                <div class="flex items-center gap-2 pt-1">
                                    @if (!empty($appliedSuggestions['fullName']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">✓ Applied to Field</span>
                                        <button wire:click="undoSuggestion('fullName')" class="px-3 py-1 rounded-xl bg-slate-700 text-slate-200 text-[10px] font-bold hover:bg-slate-600">↶ Undo</button>
                                    @else
                                        <button wire:click="applySuggestion('fullName')" style="background-color: #059669;" class="px-3.5 py-1.5 rounded-xl text-white text-[10px] font-black shadow-md hover:bg-emerald-600 transition-all">✓ Apply Suggestion</button>
                                        <button wire:click="dismissSuggestion('fullName')" class="px-2.5 py-1.5 rounded-xl bg-slate-700 text-slate-400 text-[10px] font-bold hover:bg-slate-600">× Keep Original</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- HEADLINE -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Professional Headline</label>
                        <input type="text" wire:model.live.debounce.300ms="headlineTitle" placeholder="e.g. Java Full-Stack Developer | React.js | Spring Boot" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        
                        <!-- INLINE SUGGESTION CARD FOR HEADLINE -->
                        @if (isset($fieldSuggestions['headlineTitle']) && $fieldSuggestions['headlineTitle']['can_apply'])
                            <div class="mt-2.5 p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/40 text-xs space-y-2 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-md bg-amber-500/20 text-amber-300 font-black text-[10px] uppercase tracking-wider">✨ {{ $fieldSuggestions['headlineTitle']['title'] ?? 'Headline ATS Enhancement' }}</span>
                                    <span class="text-[10px] font-bold text-amber-200 uppercase">WARNING</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">{{ $fieldSuggestions['headlineTitle']['reason'] }}</p>
                                <div class="p-2.5 rounded-xl bg-slate-900/90 text-amber-300 font-mono text-[11px] leading-relaxed whitespace-pre-line border border-amber-500/20">{{ $fieldSuggestions['headlineTitle']['suggested'] }}</div>
                                <div class="flex items-center gap-2 pt-1">
                                    @if (!empty($appliedSuggestions['headlineTitle']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">✓ Applied to Field</span>
                                        <button wire:click="undoSuggestion('headlineTitle')" class="px-3 py-1 rounded-xl bg-slate-700 text-slate-200 text-[10px] font-bold hover:bg-slate-600">↶ Undo</button>
                                    @else
                                        <button wire:click="applySuggestion('headlineTitle')" style="background-color: #059669;" class="px-3.5 py-1.5 rounded-xl text-white text-[10px] font-black shadow-md hover:bg-emerald-600 transition-all">✓ Apply Suggestion</button>
                                        <button wire:click="dismissSuggestion('headlineTitle')" class="px-2.5 py-1.5 rounded-xl bg-slate-700 text-slate-400 text-[10px] font-bold hover:bg-slate-600">× Keep Original</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- PHONE & EMAIL -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 mb-1">
                                Phone Number <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" wire:model.live.debounce.300ms="phone" placeholder="+91 8610065701" style="background: #112240; border: {{ in_array('Phone Number', $missingRequiredFields) ? '2px solid #ef4444' : '1px solid #1e3a5f' }}; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 mb-1">
                                Email Address <span class="text-rose-400">*</span>
                            </label>
                            <input type="email" wire:model.live.debounce.300ms="email" placeholder="you@email.com" style="background: #112240; border: {{ in_array('Email Address', $missingRequiredFields) ? '2px solid #ef4444' : '1px solid #1e3a5f' }}; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        </div>
                    </div>

                    <!-- LOCATION -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">City & State / Location</label>
                        <input type="text" wire:model.live.debounce.300ms="location" placeholder="e.g. Coimbatore, Tamil Nadu" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        
                        @if (isset($fieldSuggestions['location']) && $fieldSuggestions['location']['can_apply'])
                            <div class="mt-2.5 p-3.5 rounded-2xl bg-sky-500/10 border border-sky-500/40 text-xs space-y-2 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-md bg-sky-500/20 text-sky-300 font-black text-[10px] uppercase tracking-wider">✨ {{ $fieldSuggestions['location']['title'] ?? 'Location Format' }}</span>
                                    <span class="text-[10px] font-bold text-sky-200 uppercase">INFO</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">{{ $fieldSuggestions['location']['reason'] }}</p>
                                <div class="p-2.5 rounded-xl bg-slate-900/90 text-sky-300 font-mono text-[11px] leading-relaxed whitespace-pre-line border border-sky-500/20">{{ $fieldSuggestions['location']['suggested'] }}</div>
                                <div class="flex items-center gap-2 pt-1">
                                    @if (!empty($appliedSuggestions['location']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">✓ Applied to Field</span>
                                        <button wire:click="undoSuggestion('location')" class="px-3 py-1 rounded-xl bg-slate-700 text-slate-200 text-[10px] font-bold hover:bg-slate-600">↶ Undo</button>
                                    @else
                                        <button wire:click="applySuggestion('location')" style="background-color: #059669;" class="px-3.5 py-1.5 rounded-xl text-white text-[10px] font-black shadow-md hover:bg-emerald-600 transition-all">✓ Apply Suggestion</button>
                                        <button wire:click="dismissSuggestion('location')" class="px-2.5 py-1.5 rounded-xl bg-slate-700 text-slate-400 text-[10px] font-bold hover:bg-slate-600">× Keep Original</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- URLS -->
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-300 mb-1">LinkedIn URL</label>
                            <input type="text" wire:model.live.debounce.300ms="linkedin" placeholder="linkedin.com/in/you" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-2.5 py-2 rounded-xl text-[11px] focus:outline-none focus:border-rose-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-300 mb-1">GitHub URL</label>
                            <input type="text" wire:model.live.debounce.300ms="github" placeholder="github.com/you" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-2.5 py-2 rounded-xl text-[11px] focus:outline-none focus:border-rose-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-300 mb-1">Portfolio URL</label>
                            <input type="text" wire:model.live.debounce.300ms="portfolio" placeholder="yoursite.dev" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-2.5 py-2 rounded-xl text-[11px] focus:outline-none focus:border-rose-500">
                        </div>
                    </div>

                    <!-- PROFESSIONAL SUMMARY -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Professional Summary / Experience</label>
                        <textarea wire:model.live.debounce.300ms="experienceSummary" rows="3" placeholder="Describe your experience, background, and career goals..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500"></textarea>
                        
                        <!-- INLINE AI CARD FOR SUMMARY -->
                        @if (isset($fieldSuggestions['experienceSummary']) && $fieldSuggestions['experienceSummary']['can_apply'])
                            <div class="mt-2.5 p-3.5 rounded-2xl bg-rose-500/10 border border-rose-500/40 text-xs space-y-2 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-md bg-rose-500/20 text-rose-300 font-black text-[10px] uppercase tracking-wider">✨ {{ $fieldSuggestions['experienceSummary']['title'] ?? 'Summary Enhancement' }}</span>
                                    <span class="text-[10px] font-bold text-rose-300 uppercase">CRITICAL</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">{{ $fieldSuggestions['experienceSummary']['reason'] }}</p>
                                <div class="p-2.5 rounded-xl bg-slate-900/90 text-emerald-300 font-mono text-[11.5px] leading-relaxed whitespace-pre-line border border-emerald-500/30">{{ $fieldSuggestions['experienceSummary']['suggested'] }}</div>
                                <div class="flex items-center gap-2 pt-1">
                                    @if (!empty($appliedSuggestions['experienceSummary']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">✓ Applied to Field</span>
                                        <button wire:click="undoSuggestion('experienceSummary')" class="px-3 py-1 rounded-xl bg-slate-700 text-slate-200 text-[10px] font-bold hover:bg-slate-600">↶ Undo</button>
                                    @else
                                        <button wire:click="applySuggestion('experienceSummary')" style="background-color: #059669;" class="px-3.5 py-1.5 rounded-xl text-white text-[10px] font-black shadow-md hover:bg-emerald-600 transition-all">✓ Apply Suggestion</button>
                                        <button wire:click="dismissSuggestion('experienceSummary')" class="px-2.5 py-1.5 rounded-xl bg-slate-700 text-slate-400 text-[10px] font-bold hover:bg-slate-600">× Keep Original</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- EDUCATION -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">
                            Education Details <span class="text-rose-400">*</span> (Degree | College | CGPA | Year)
                        </label>
                        <textarea wire:model.live.debounce.300ms="educationRaw" rows="2" placeholder="B.E. Computer Science | ABC College | CGPA 8.1 | 2026" style="background: #112240; border: {{ in_array('Education Details', $missingRequiredFields) ? '2px solid #ef4444' : '1px solid #1e3a5f' }}; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500"></textarea>
                        
                        <!-- INLINE AI CARD FOR EDUCATION -->
                        @if (isset($fieldSuggestions['educationRaw']) && $fieldSuggestions['educationRaw']['can_apply'])
                            <div class="mt-2.5 p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/40 text-xs space-y-2 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-md bg-amber-500/20 text-amber-300 font-black text-[10px] uppercase tracking-wider">✨ {{ $fieldSuggestions['educationRaw']['title'] ?? 'Education Formatting' }}</span>
                                    <span class="text-[10px] font-bold text-amber-200 uppercase">WARNING</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">{{ $fieldSuggestions['educationRaw']['reason'] }}</p>
                                <div class="p-2.5 rounded-xl bg-slate-900/90 text-amber-300 font-mono text-[11px] leading-relaxed whitespace-pre-line border border-amber-500/20">{{ $fieldSuggestions['educationRaw']['suggested'] }}</div>
                                <div class="flex items-center gap-2 pt-1">
                                    @if (!empty($appliedSuggestions['educationRaw']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">✓ Applied to Field</span>
                                        <button wire:click="undoSuggestion('educationRaw')" class="px-3 py-1 rounded-xl bg-slate-700 text-slate-200 text-[10px] font-bold hover:bg-slate-600">↶ Undo</button>
                                    @else
                                        <button wire:click="applySuggestion('educationRaw')" style="background-color: #059669;" class="px-3.5 py-1.5 rounded-xl text-white text-[10px] font-black shadow-md hover:bg-emerald-600 transition-all">✓ Apply Suggestion</button>
                                        <button wire:click="dismissSuggestion('educationRaw')" class="px-2.5 py-1.5 rounded-xl bg-slate-700 text-slate-400 text-[10px] font-bold hover:bg-slate-600">× Keep Original</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- TECHNICAL SKILLS -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">
                            Technical Skills <span class="text-rose-400">*</span> (Category: skill1, skill2)
                        </label>
                        <textarea wire:model.live.debounce.300ms="skillsInput" rows="3" placeholder="Languages: Java, Python, SQL&#10;Frontend: React, HTML5, CSS3&#10;Backend: Node.js, Spring Boot" style="background: #112240; border: {{ in_array('Technical Skills or Projects', $missingRequiredFields) ? '2px solid #ef4444' : '1px solid #1e3a5f' }}; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500"></textarea>
                        
                        <!-- INLINE AI CARD FOR SKILLS -->
                        @if (isset($fieldSuggestions['skillsInput']) && $fieldSuggestions['skillsInput']['can_apply'])
                            <div class="mt-2.5 p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/40 text-xs space-y-2 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-md bg-amber-500/20 text-amber-300 font-black text-[10px] uppercase tracking-wider">✨ {{ $fieldSuggestions['skillsInput']['title'] ?? 'Skills Categorization' }}</span>
                                    <span class="text-[10px] font-bold text-amber-200 uppercase">WARNING</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">{{ is_array($fieldSuggestions['skillsInput']['reason'] ?? null) ? implode(' ', $fieldSuggestions['skillsInput']['reason']) : ($fieldSuggestions['skillsInput']['reason'] ?? '') }}</p>
                                <div class="p-2.5 rounded-xl bg-slate-900/90 text-amber-300 font-mono text-[11px] leading-relaxed whitespace-pre-line border border-amber-500/20">{{ is_array($fieldSuggestions['skillsInput']['suggested'] ?? null) ? implode("\n", $fieldSuggestions['skillsInput']['suggested']) : ($fieldSuggestions['skillsInput']['suggested'] ?? '') }}</div>
                                <div class="flex items-center gap-2 pt-1">
                                    @if (!empty($appliedSuggestions['skillsInput']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">✓ Applied to Field</span>
                                        <button wire:click="undoSuggestion('skillsInput')" class="px-3 py-1 rounded-xl bg-slate-700 text-slate-200 text-[10px] font-bold hover:bg-slate-600">↶ Undo</button>
                                    @else
                                        <button wire:click="applySuggestion('skillsInput')" style="background-color: #059669;" class="px-3.5 py-1.5 rounded-xl text-white text-[10px] font-black shadow-md hover:bg-emerald-600 transition-all">✓ Apply Suggestion</button>
                                        <button wire:click="dismissSuggestion('skillsInput')" class="px-2.5 py-1.5 rounded-xl bg-slate-700 text-slate-400 text-[10px] font-bold hover:bg-slate-600">× Keep Original</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- PROJECTS -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Projects (Title — Tech Stack, then bullet points with -)</label>
                        <textarea wire:model.live.debounce.300ms="projectsRaw" rows="4" placeholder="College Management System — Java, SQL (Academic Project):&#10;- Developed modules for student records and attendance" style="background: #112240; border: {{ in_array('Technical Skills or Projects', $missingRequiredFields) ? '2px solid #ef4444' : '1px solid #1e3a5f' }}; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500"></textarea>
                        
                        <!-- INLINE AI CARD FOR PROJECTS -->
                        @if (isset($fieldSuggestions['projectsRaw']) && $fieldSuggestions['projectsRaw']['can_apply'])
                            <div class="mt-2.5 p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/40 text-xs space-y-2 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-md bg-amber-500/20 text-amber-300 font-black text-[10px] uppercase tracking-wider">✨ {{ $fieldSuggestions['projectsRaw']['title'] ?? 'Projects Enhancement' }}</span>
                                    <span class="text-[10px] font-bold text-amber-200 uppercase">WARNING</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">{{ is_array($fieldSuggestions['projectsRaw']['reason'] ?? null) ? implode(' ', $fieldSuggestions['projectsRaw']['reason']) : ($fieldSuggestions['projectsRaw']['reason'] ?? '') }}</p>
                                <div class="p-2.5 rounded-xl bg-slate-900/90 text-amber-300 font-mono text-[11px] leading-relaxed whitespace-pre-line border border-amber-500/20">{{ is_array($fieldSuggestions['projectsRaw']['suggested'] ?? null) ? implode("\n", $fieldSuggestions['projectsRaw']['suggested']) : ($fieldSuggestions['projectsRaw']['suggested'] ?? '') }}</div>
                                <div class="flex items-center gap-2 pt-1">
                                    @if (!empty($appliedSuggestions['projectsRaw']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">✓ Applied to Field</span>
                                        <button wire:click="undoSuggestion('projectsRaw')" class="px-3 py-1 rounded-xl bg-slate-700 text-slate-200 text-[10px] font-bold hover:bg-slate-600">↶ Undo</button>
                                    @else
                                        <button wire:click="applySuggestion('projectsRaw')" style="background-color: #059669;" class="px-3.5 py-1.5 rounded-xl text-white text-[10px] font-black shadow-md hover:bg-emerald-600 transition-all">✓ Apply Suggestion</button>
                                        <button wire:click="dismissSuggestion('projectsRaw')" class="px-2.5 py-1.5 rounded-xl bg-slate-700 text-slate-400 text-[10px] font-bold hover:bg-slate-600">× Keep Original</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- CERTIFICATIONS & ACHIEVEMENTS -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Certifications & Achievements</label>
                        <textarea wire:model.live.debounce.300ms="certificationsRaw" rows="2" placeholder="Java Programming Course — Udemy&#10;First Prize — Hackathon 2025" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500"></textarea>
                        
                        <!-- INLINE AI CARD FOR CERTIFICATIONS -->
                        @if (isset($fieldSuggestions['certificationsRaw']) && $fieldSuggestions['certificationsRaw']['can_apply'])
                            <div class="mt-2.5 p-3.5 rounded-2xl bg-sky-500/10 border border-sky-500/40 text-xs space-y-2 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-md bg-sky-500/20 text-sky-300 font-black text-[10px] uppercase tracking-wider">✨ {{ $fieldSuggestions['certificationsRaw']['title'] ?? 'Certifications Formatting' }}</span>
                                    <span class="text-[10px] font-bold text-sky-200 uppercase">INFO</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">{{ $fieldSuggestions['certificationsRaw']['reason'] }}</p>
                                <div class="p-2.5 rounded-xl bg-slate-900/90 text-sky-300 font-mono text-[11px] leading-relaxed whitespace-pre-line border border-sky-500/20">{{ $fieldSuggestions['certificationsRaw']['suggested'] }}</div>
                                <div class="flex items-center gap-2 pt-1">
                                    @if (!empty($appliedSuggestions['certificationsRaw']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">✓ Applied to Field</span>
                                        <button wire:click="undoSuggestion('certificationsRaw')" class="px-3 py-1 rounded-xl bg-slate-700 text-slate-200 text-[10px] font-bold hover:bg-slate-600">↶ Undo</button>
                                    @else
                                        <button wire:click="applySuggestion('certificationsRaw')" style="background-color: #059669;" class="px-3.5 py-1.5 rounded-xl text-white text-[10px] font-black shadow-md hover:bg-emerald-600 transition-all">✓ Apply Suggestion</button>
                                        <button wire:click="dismissSuggestion('certificationsRaw')" class="px-2.5 py-1.5 rounded-xl bg-slate-700 text-slate-400 text-[10px] font-bold hover:bg-slate-600">× Keep Original</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- SOFT SKILLS -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Soft Skills (Comma Separated)</label>
                        <input type="text" wire:model.live.debounce.300ms="softSkillsInput" placeholder="Problem Solving, Team Work, Communication" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        
                        @if (isset($fieldSuggestions['softSkillsInput']) && $fieldSuggestions['softSkillsInput']['can_apply'])
                            <div class="mt-2.5 p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/40 text-xs space-y-2 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-md bg-amber-500/20 text-amber-300 font-black text-[10px] uppercase tracking-wider">✨ {{ $fieldSuggestions['softSkillsInput']['title'] ?? 'Soft Skills Wording' }}</span>
                                    <span class="text-[10px] font-bold text-amber-200 uppercase">INFO</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">{{ $fieldSuggestions['softSkillsInput']['reason'] }}</p>
                                <div class="p-2.5 rounded-xl bg-slate-900/90 text-amber-300 font-mono text-[11px] leading-relaxed whitespace-pre-line border border-amber-500/20">{{ $fieldSuggestions['softSkillsInput']['suggested'] }}</div>
                                <div class="flex items-center gap-2 pt-1">
                                    @if (!empty($appliedSuggestions['softSkillsInput']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-[10px]">✓ Applied to Field</span>
                                        <button wire:click="undoSuggestion('softSkillsInput')" class="px-3 py-1 rounded-xl bg-slate-700 text-slate-200 text-[10px] font-bold hover:bg-slate-600">↶ Undo</button>
                                    @else
                                        <button wire:click="applySuggestion('softSkillsInput')" style="background-color: #059669;" class="px-3.5 py-1.5 rounded-xl text-white text-[10px] font-black shadow-md hover:bg-emerald-600 transition-all">✓ Apply Suggestion</button>
                                        <button wire:click="dismissSuggestion('softSkillsInput')" class="px-2.5 py-1.5 rounded-xl bg-slate-700 text-slate-400 text-[10px] font-bold hover:bg-slate-600">× Keep Original</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- TARGET JOB DESCRIPTION -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Target Job Description (for ATS Keyword Matching)</label>
                        <textarea wire:model.live.debounce.300ms="targetJobDescription" rows="2" placeholder="Paste the job description you're applying to..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500"></textarea>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="space-y-3 pt-2">
                        <!-- BUTTON 1: GET FIELD SUGGESTIONS -->
                        <button wire:click="getAiSuggestions" wire:loading.attr="disabled" style="background-color: #1e3a5f; border: 1px solid #3b82f6;" class="w-full py-3.5 rounded-xl text-white font-black text-xs shadow-md hover:bg-slate-800 transition-all flex items-center justify-center gap-2 disabled:opacity-50">
                            <span wire:loading.remove wire:target="getAiSuggestions">✨ Suggestions & Recommendations</span>
                            <span wire:loading wire:target="getAiSuggestions" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Analyzing Field-by-Field...</span>
                            </span>
                        </button>

                        <!-- BUTTON 2: INSTANT DOWNLOAD ATS RESUME PDF -->
                        <a href="{{ route('student.career.resume.download-pdf') }}" target="_blank" style="background-color: #D62828;" class="w-full py-3.5 rounded-xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition-all flex items-center justify-center gap-2 text-decoration-none">
                            <span>⬇️ Download ATS Resume PDF</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: AI HEALTH PANEL + ATS SCORE + PAPER PREVIEW (7 COLUMNS) -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- AI RESUME QUALITY HEALTH PANEL -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 text-white shadow-xl space-y-4">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">AI Resume Quality Health</div>
                        <h3 class="text-xl font-black text-white mt-0.5">
                            ATS Score:
                            <span class="{{ $atsScore >= 80 ? 'text-emerald-400' : ($atsScore >= 50 ? 'text-amber-400' : 'text-rose-400') }}">
                                {{ $atsScore > 0 ? $atsScore . '/100' : '—' }}
                            </span>
                        </h3>
                    </div>
                    
                    @if (count($fieldSuggestions) > 0)
                        <button wire:click="applyAllSuggestions" style="background-color: #059669;" class="px-4 py-2.5 rounded-xl text-white text-xs font-black shadow-lg hover:bg-emerald-600 transition flex items-center gap-1.5">
                            <span>✨ Apply All Suggestions</span>
                        </button>
                    @endif
                </div>

                <!-- SECTION HEALTH CHECKLIST -->
                <div class="grid grid-cols-5 gap-2 pt-1 text-center text-[10px] font-bold">
                    <div class="p-2 rounded-xl {{ !empty($qualityChecklist['contact']) ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }}">
                        {{ !empty($qualityChecklist['contact']) ? '✓' : '🔴' }} Contact Info
                    </div>
                    <div class="p-2 rounded-xl {{ !empty($qualityChecklist['education']) ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }}">
                        {{ !empty($qualityChecklist['education']) ? '✓' : '🔴' }} Education
                    </div>
                    <div class="p-2 rounded-xl {{ !empty($qualityChecklist['summary']) ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30' }}">
                        {{ !empty($qualityChecklist['summary']) ? '✓' : '⚠' }} Summary
                    </div>
                    <div class="p-2 rounded-xl {{ !empty($qualityChecklist['skills']) ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }}">
                        {{ !empty($qualityChecklist['skills']) ? '✓' : '🔴' }} Skills
                    </div>
                    <div class="p-2 rounded-xl {{ !empty($qualityChecklist['projects']) ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30' }}">
                        {{ !empty($qualityChecklist['projects']) ? '✓' : '⚠' }} Projects
                    </div>
                </div>

                <!-- KEYWORD MATCHES & MISSING -->
                @if (count($matchedKeywords) > 0 && $matchedKeywords[0] !== 'N/A')
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @foreach ($matchedKeywords as $kw)
                            <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-bold">✓ {{ $kw }}</span>
                        @endforeach
                        @foreach ($missingKeywords as $mkw)
                            <span class="px-2 py-0.5 rounded-md bg-rose-500/20 text-rose-300 border border-rose-500/30 text-[10px] font-bold">✗ {{ $mkw }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- SUGGESTED SKILLS BADGES -->
                @if (count($suggestedSkills) > 0)
                    <div class="flex items-center gap-1.5 flex-wrap text-[11px] pt-1">
                        <span class="text-slate-400 font-semibold">Recommended Skills to Add:</span>
                        @foreach ($suggestedSkills as $ss)
                            <button wire:click="addSuggestedSkill('{{ $ss }}')" type="button" class="px-2 py-0.5 rounded bg-sky-500/20 text-sky-300 border border-sky-500/30 text-[10px] font-bold cursor-pointer hover:bg-sky-500/40 transition">
                                + {{ $ss }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- LIVE ATS RESUME PAPER PREVIEW -->
            @if ($generatedResume && !empty($generatedResume['name']))
                <div style="background-color: #ffffff !important; color: #111827 !important;" class="rounded-xl p-8 sm:p-10 shadow-2xl space-y-4 font-serif text-[13px] leading-snug border border-slate-300">
                    <!-- HEADER -->
                    <div class="text-center" style="color: #111827 !important;">
                        <h1 style="color: #000000 !important;" class="text-2xl font-bold uppercase tracking-wider m-0">{{ $generatedResume['name'] ?? '' }}</h1>
                        @if (!empty($generatedResume['headline']))
                            <div style="color: #374151 !important;" class="text-xs italic mt-1">{{ $generatedResume['headline'] }}</div>
                        @endif
                        <div style="color: #374151 !important;" class="text-[11px] mt-1">
                            @php
                                $contactParts = array_filter([
                                    $generatedResume['phone'] ?? '',
                                    $generatedResume['email'] ?? '',
                                    $generatedResume['location'] ?? '',
                                ]);
                            @endphp
                            {{ implode(' | ', $contactParts) }}
                            @if (!empty($generatedResume['linkedin'])) | <a href="#" style="color: #000000 !important;" class="underline">LinkedIn</a> @endif
                            @if (!empty($generatedResume['github'])) | <a href="#" style="color: #000000 !important;" class="underline">GitHub</a> @endif
                            @if (!empty($generatedResume['portfolio'])) | <a href="#" style="color: #000000 !important;" class="underline">Portfolio</a> @endif
                        </div>
                    </div>

                    <!-- PROFESSIONAL SUMMARY -->
                    @if (!empty($generatedResume['professional_summary']))
                        <div class="pt-2">
                            <div style="color: #000000 !important; border-top: 2px solid #000000 !important;" class="text-xs font-bold uppercase tracking-wider pt-1 mb-1">PROFESSIONAL SUMMARY</div>
                            <p style="color: #1f2937 !important;" class="text-xs text-justify leading-relaxed">
                                {{ $generatedResume['professional_summary'] }}
                            </p>
                        </div>
                    @endif

                    <!-- EDUCATION -->
                    @if (!empty($generatedResume['education']))
                        <div>
                            <div style="color: #000000 !important; border-top: 2px solid #000000 !important;" class="text-xs font-bold uppercase tracking-wider pt-1 mb-1">EDUCATION</div>
                            @foreach ($generatedResume['education'] as $edu)
                                @if (!empty($edu['degree']))
                                    <div style="color: #000000 !important;" class="flex justify-between items-baseline text-xs font-bold">
                                        <span style="color: #000000 !important;">{{ $edu['degree'] }}</span>
                                        @if (!empty($edu['year']))
                                            <span style="color: #374151 !important;" class="italic font-normal">{{ $edu['year'] }}</span>
                                        @endif
                                    </div>
                                    <div style="color: #1f2937 !important;" class="text-xs">
                                        {{ $edu['institution'] ?? '' }}
                                        @if (!empty($edu['cgpa'])) | <strong style="color: #000000 !important;">{{ $edu['cgpa'] }}</strong> @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <!-- TECHNICAL SKILLS -->
                    @if (!empty($generatedResume['technical_skills']))
                        <div>
                            <div style="color: #000000 !important; border-top: 2px solid #000000 !important;" class="text-xs font-bold uppercase tracking-wider pt-1 mb-1">TECHNICAL SKILLS</div>
                            <div style="color: #1f2937 !important;" class="space-y-0.5 text-xs">
                                @foreach ($generatedResume['technical_skills'] as $cat => $val)
                                    <div>
                                        <strong style="color: #000000 !important;" class="font-bold">{{ $cat }}:</strong> {{ is_array($val) ? implode(', ', $val) : $val }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- PROJECTS -->
                    @if (!empty($generatedResume['projects']))
                        <div>
                            <div style="color: #000000 !important; border-top: 2px solid #000000 !important;" class="text-xs font-bold uppercase tracking-wider pt-1 mb-1">PROJECTS</div>
                            @foreach ($generatedResume['projects'] as $p)
                                <div style="color: #000000 !important;" class="flex justify-between items-baseline text-xs">
                                    <span style="color: #000000 !important;" class="font-bold">{{ $p['title'] ?? 'Project' }} @if (!empty($p['tech_stack'])) — <span style="color: #374151 !important;" class="font-normal">{{ $p['tech_stack'] }}</span> @endif</span>
                                    @if (!empty($p['badge'])) <span style="color: #374151 !important;" class="italic font-semibold">{{ $p['badge'] }}</span> @endif
                                </div>
                                @if (!empty($p['bullets']))
                                    <ul style="color: #1f2937 !important;" class="list-disc list-inside text-xs pl-2 my-1 space-y-0.5">
                                        @foreach ($p['bullets'] as $b)
                                            <li style="color: #1f2937 !important;">{{ $b }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <!-- CERTIFICATIONS & ACHIEVEMENTS (Filtered to omit empty text) -->
                    @php
                        $paperCerts = array_filter($generatedResume['certifications'] ?? [], function($c) {
                            return !empty(trim($c)) && strtolower(trim($c)) !== 'no certifications listed';
                        });
                    @endphp
                    @if (count($paperCerts) > 0)
                        <div>
                            <div style="color: #000000 !important; border-top: 2px solid #000000 !important;" class="text-xs font-bold uppercase tracking-wider pt-1 mb-1">CERTIFICATIONS & ACHIEVEMENTS</div>
                            <ul style="color: #1f2937 !important;" class="list-disc list-inside text-xs pl-2 space-y-0.5">
                                @foreach ($paperCerts as $c)
                                    <li style="color: #1f2937 !important;">{{ $c }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- SOFT SKILLS -->
                    @php
                        $paperSoft = array_filter(is_array($generatedResume['soft_skills'] ?? []) ? $generatedResume['soft_skills'] : explode(',', $generatedResume['soft_skills'] ?? ''), function($s) {
                            return !empty(trim($s));
                        });
                    @endphp
                    @if (count($paperSoft) > 0)
                        <div>
                            <div style="color: #000000 !important; border-top: 2px solid #000000 !important;" class="text-xs font-bold uppercase tracking-wider pt-1 mb-1">SOFT SKILLS</div>
                            <div style="color: #111827 !important;" class="text-xs text-center pt-0.5">
                                {{ implode('   •   ', array_map('trim', $paperSoft)) }}
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <!-- EMPTY STATE -->
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-10 text-center shadow-xl">
                    <div class="text-4xl mb-3">📄</div>
                    <h3 class="text-lg font-black text-white mb-1">Your Resume Preview</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">Fill in your details on the left. Click <strong class="text-blue-400">✨ Suggestions & Recommendations</strong> to get field-by-field AI improvements, or <strong class="text-rose-400">⚡ Generate & Auto-Download PDF</strong> to compile your resume.</p>
                </div>
            @endif
        </div>
    </div>
</div>
