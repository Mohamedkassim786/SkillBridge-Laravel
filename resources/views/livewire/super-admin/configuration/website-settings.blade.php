<div class="space-y-6 max-w-4xl mx-auto">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Dynamic Website CMS Branding & Content Engine</h1>
            <p class="text-xs text-slate-300">Edit website branding, homepage hero headlines, contact details, and maintenance mode status directly stored in database.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-6 text-white">
        <form wire:submit.prevent="saveSettings" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Website Brand Name</label>
                    <input type="text" wire:model="appName" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Maintenance Mode</label>
                    <select wire:model="maintenanceMode" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-bold">
                        <option value="0">Off (Website Live)</option>
                        <option value="1">On (Maintenance Notice Active)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Homepage Hero Headline</label>
                <input type="text" wire:model="heroHeadline" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-bold">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Homepage Hero Subheading</label>
                <textarea wire:model="heroSubheading" rows="3" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full p-4 rounded-xl text-xs focus:outline-none"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Contact Support Email</label>
                    <input type="email" wire:model="contactEmail" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Support Phone Line</label>
                    <input type="text" wire:model="supportPhone" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">⚡ CMS changes dynamically update the public homepage.</span>
                <button type="submit" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-md">
                    Save Website Settings
                </button>
            </div>
        </form>
    </div>
</div>
