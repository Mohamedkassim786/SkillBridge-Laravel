<div class="space-y-6" style="background-color: #081628; color: #cbd5e1;">
    <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 24px;" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Hiring Partner Companies</h1>
            <p class="text-xs text-slate-400 mt-1">Manage corporate accounts and active recruiters.</p>
        </div>
        <button style="background: #D62828; color: white;" class="px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-700 transition-all">+ Add Company</button>
    </div>

    <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 24px;">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach (['TCS', 'Infosys', 'Wipro', 'Amazon', 'Microsoft', 'Google', 'Zoho', 'Freshworks', 'Cognizant'] as $cName)
                <div style="background: #081628; border: 1px solid #1e3a5f; border-radius: 16px; padding: 20px;" class="flex items-center gap-4">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: #D62828; color: white; font-weight: 900; font-size: 18px;" class="flex items-center justify-center shrink-0">
                        {{ strtoupper(substr($cName, 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-sm font-extrabold text-white">{{ $cName }}</div>
                        <div class="text-xs text-slate-400">10,000+ Employees • Verified</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
