<div class="space-y-8" x-data="{ modalOpen: @entangle('showModal') }">
    <!-- Admin Header -->
    <div class="p-6 rounded-3xl bg-gradient-to-r from-[#251237] to-[#1e0d2d] text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6 border border-purple-800/40">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-widest">
                <span>SkillBridge Admin Panel</span>
                <span>•</span>
                <span class="text-[#f15153]">Student Enrollments & Access Manager</span>
            </div>
            <h1 class="text-2xl font-extrabold text-white mt-1">Manage Student Enrollments</h1>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">Assign courses to students. Enrolled students gain immediate access to course lessons, video streaming, and learning tracking.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search student or course..." class="px-4 py-2.5 rounded-xl bg-slate-800 text-white text-xs font-bold border border-slate-700 focus:ring-2 focus:ring-[#f15153] outline-none">

            <button wire:click="openCreateModal" class="px-5 py-2.5 rounded-xl bg-[#f15153] hover:bg-red-700 text-white text-xs font-extrabold shadow-lg flex items-center gap-2 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Enroll Student</span>
            </button>
        </div>
    </div>

    <!-- Enrollments Table -->
    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-slate-200 text-slate-500 font-extrabold uppercase text-[10px]">
                    <th class="pb-3 px-3">Student</th>
                    <th class="pb-3 px-3">Enrolled Course</th>
                    <th class="pb-3 px-3">Progress</th>
                    <th class="pb-3 px-3">Status</th>
                    <th class="pb-3 px-3">Enrolled At</th>
                    <th class="pb-3 px-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                @forelse ($enrollments as $enr)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-3">
                            <div class="font-bold text-[#251237]">{{ $enr->user?->name ?? 'User' }}</div>
                            <div class="text-[11px] text-slate-500">{{ $enr->user?->email }}</div>
                        </td>
                        <td class="py-3 px-3">
                            <div class="font-bold text-slate-800">{{ $enr->course?->title ?? 'Course' }}</div>
                        </td>
                        <td class="py-3 px-3">
                            <div class="flex items-center gap-2">
                                <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-[#f15153] h-full" style="width: {{ $enr->progress_percent }}%"></div>
                                </div>
                                <span class="font-bold text-xs">{{ $enr->progress_percent }}%</span>
                            </div>
                        </td>
                        <td class="py-3 px-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $enr->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $enr->status }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-slate-500 text-[11px]">
                            {{ $enr->created_at?->format('M d, Y') }}
                        </td>
                        <td class="py-3 px-3 text-right">
                            <button wire:click="cancelEnrollment('{{ $enr->id }}')" wire:confirm="Revoke student enrollment?" class="px-3 py-1.5 rounded-xl bg-red-100 hover:bg-red-200 text-red-700 font-bold text-xs transition-all">
                                Revoke Access
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500 font-semibold">
                            No student enrollments found. Click "Enroll Student" above.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Enroll Student Modal -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-3xl bg-white p-6 sm:p-8 shadow-2xl space-y-6" @click.away="modalOpen = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-extrabold text-[#251237]">Enroll Student into Course</h3>
                <button @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">✕</button>
            </div>

            <form wire:submit.prevent="enrollStudent" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Student</label>
                    <select wire:model="user_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-[#f15153]">
                        @foreach ($students as $st)
                            <option value="{{ $st->id }}">{{ $st->name }} ({{ $st->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Course</label>
                    <select wire:model="course_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-[#f15153]">
                        @foreach ($courses as $cs)
                            <option value="{{ $cs->id }}">{{ $cs->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#f15153] hover:bg-red-700 text-white text-xs font-extrabold shadow-md">
                        Enroll Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
