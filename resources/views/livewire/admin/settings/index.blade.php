<div class="space-y-6" style="background-color: #081628; color: #cbd5e1;">
    <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 24px;">
        <h1 class="text-2xl font-black text-white tracking-tight">System & Platform Settings</h1>
        <p class="text-xs text-slate-400 mt-1">Configure global branding, payment credentials, email gateways, and CMS parameters.</p>
    </div>

    <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 28px;" class="max-w-2xl space-y-4">
        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Site Name</label>
                <input type="text" wire:model="siteName" style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Support Email</label>
                <input type="email" wire:model="siteEmail" style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Support Phone</label>
                <input type="text" wire:model="sitePhone" style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs outline-none">
            </div>
            <button type="submit" style="background: #D62828; color: white;" class="px-6 py-2.5 rounded-xl font-bold text-xs hover:bg-red-700">Save Changes</button>
        </form>
    </div>
</div>
