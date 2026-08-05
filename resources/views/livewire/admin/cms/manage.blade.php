<div class="space-y-8">
    <!-- Admin Header -->
    <div class="p-6 rounded-3xl bg-gradient-to-r from-[#0B1F3A] to-slate-900 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-widest">
                <span>SkillBridge Admin CMS</span>
                <span>•</span>
                <span class="text-[#D62828]">Public Website Control Panel</span>
            </div>
            <h1 class="text-2xl font-extrabold text-white mt-1">Manage Public Website Content</h1>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">Control every section of the public website. Edits made here update the public home page, hero banners, site contacts, and FAQs in real-time.</p>
        </div>

        <div class="flex items-center gap-2">
            <button wire:click="$set('activeTab', 'hero')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $activeTab === 'hero' ? 'bg-[#D62828] text-white shadow-md' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                Hero & Branding
            </button>
            <button wire:click="$set('activeTab', 'faq')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $activeTab === 'faq' ? 'bg-[#D62828] text-white shadow-md' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                FAQs Manager
            </button>
        </div>
    </div>

    @if ($activeTab === 'hero')
        <!-- Hero & Site Settings Form -->
        <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-6">
            <h3 class="text-lg font-extrabold text-[#0B1F3A]">Hero Banner & Contact Information</h3>

            <form wire:submit.prevent="saveSettings" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Hero Headline</label>
                    <input type="text" wire:model="hero_headline" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#0B1F3A] focus:ring-2 focus:ring-[#D62828]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Hero Subheading</label>
                    <textarea wire:model="hero_subheading" rows="3" class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 focus:ring-2 focus:ring-[#D62828]"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Platform Brand Name</label>
                        <input type="text" wire:model="site_name" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Contact Phone</label>
                        <input type="text" wire:model="site_phone" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Contact Email</label>
                        <input type="email" wire:model="site_email" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Office Address</label>
                        <input type="text" wire:model="site_address" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D62828] hover:bg-red-700 text-white font-extrabold text-xs shadow-md">
                        Save CMS Settings 💾
                    </button>
                </div>
            </form>
        </div>
    @else
        <!-- FAQ Manager -->
        <div class="space-y-6">
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-base font-extrabold text-[#0B1F3A]">Add New FAQ Question</h3>

                <form wire:submit.prevent="addFaq" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Question</label>
                            <input type="text" wire:model="new_faq_question" placeholder="e.g. Can I verify my certificate code online?" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Category</label>
                            <select wire:model="new_faq_category" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold">
                                <option value="General">General</option>
                                <option value="Courses">Courses</option>
                                <option value="Pricing">Pricing</option>
                                <option value="Certificates">Certificates</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Answer</label>
                        <textarea wire:model="new_faq_answer" rows="2" placeholder="Write comprehensive answer..." class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium"></textarea>
                    </div>

                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#0B1F3A] hover:bg-slate-900 text-white font-extrabold text-xs shadow-md">
                        Add FAQ
                    </button>
                </form>
            </div>

            <!-- Existing FAQs Table -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-500 font-extrabold uppercase text-[10px]">
                            <th class="pb-3 px-3">Category</th>
                            <th class="pb-3 px-3">Question</th>
                            <th class="pb-3 px-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                        @forelse ($faqs as $f)
                            <tr>
                                <td class="py-3 px-3">
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold">{{ $f->category }}</span>
                                </td>
                                <td class="py-3 px-3 font-bold text-[#0B1F3A]">{{ $f->question }}</td>
                                <td class="py-3 px-3 text-right">
                                    <button wire:click="deleteFaq('{{ $f->id }}')" wire:confirm="Delete this FAQ?" class="px-3 py-1.5 rounded-xl bg-red-100 hover:bg-red-200 text-red-700 font-bold text-xs">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-slate-500 font-semibold">No FAQs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
