<div class="space-y-6">

    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Job Postings Management</h1>
            <p class="text-xs text-slate-500 mt-1">Audit, approve, and manage software engineering job listings from partner companies.</p>
        </div>

        <div class="flex items-center gap-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search job title..." class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-rose-500">
            <button style="background: #D62828; color: white;" class="px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-700 transition-all">+ Post Job</button>
        </div>
    </div>

    <!-- JOBS DATA TABLE -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-900">
                        <th class="p-4 font-bold">Job Title</th>
                        <th class="p-4 font-bold">Company</th>
                        <th class="p-4 font-bold">Location</th>
                        <th class="p-4 font-bold">Salary Package</th>
                        <th class="p-4 font-bold text-center">Status</th>
                        <th class="p-4 font-bold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($jobs as $j)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 font-bold text-slate-900">{{ $j->title }}</td>
                            <td class="p-4 text-rose-600 font-semibold">{{ $j->company?->name ?? 'TCS' }}</td>
                            <td class="p-4 text-slate-500 font-medium">{{ $j->location ?? 'Chennai, Tamil Nadu' }}</td>
                            <td class="p-4 font-bold text-emerald-600">₹5L - ₹8L per annum</td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    Active
                                </span>
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <a href="{{ route('jobs.show', $j->id) }}" class="px-3 py-1 bg-slate-100 border border-slate-200 text-slate-800 rounded-lg text-xs font-bold hover:bg-slate-200 inline-block text-decoration-none">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">No job postings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $jobs->links() }}
        </div>
    </div>

</div>
