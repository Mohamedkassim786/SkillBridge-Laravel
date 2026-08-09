<div class="space-y-6 max-w-4xl mx-auto">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Database-Driven SEO Meta & Robots.txt Manager</h1>
            <p class="text-xs text-slate-300">Manage global meta titles, Open Graph image URLs, canonical domains, and edit robots.txt directly from database settings.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-6 text-white">
        <form wire:submit.prevent="saveSeo" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Global Meta Title Tag</label>
                <input type="text" wire:model="globalMetaTitle" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-bold">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Global Meta Description Tag</label>
                <textarea wire:model="globalMetaDescription" rows="3" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full p-4 rounded-xl text-xs focus:outline-none"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">OpenGraph Image URL</label>
                    <input type="text" wire:model="ogImageUrl" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Canonical URL Origin</label>
                    <input type="text" wire:model="canonicalUrl" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Robots.txt Content Editor</label>
                <textarea wire:model="robotsTxt" rows="5" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full p-4 rounded-xl text-xs font-mono focus:outline-none"></textarea>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">🔍 Dynamic database-driven SEO meta tags.</span>
                <button type="submit" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-md">
                    Save SEO Configuration
                </button>
            </div>
        </form>
    </div>
</div>
