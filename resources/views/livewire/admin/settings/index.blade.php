<div class="space-y-6" x-data="{}">

    <!-- Flash Status Messages -->
    @if (session()->has('status'))
        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 font-bold text-xs flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('status') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white text-sm">✕</button>
        </div>
    @endif

    <!-- TOP SECTION & BREADCRUMB -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-800 pb-6">
        <div>
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 font-semibold mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                <span>&gt;</span>
                <span class="text-rose-400 font-bold">Settings</span>
            </nav>
            <h1 class="text-2xl font-black text-white tracking-tight">Website Settings</h1>
            <p class="text-xs text-slate-400 mt-0.5 font-medium">Configure platform defaults, SEO metadata, payment gateways, and email dispatch.</p>
        </div>
    </div>

    <!-- MAIN TWO COLUMN SETTINGS LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- VERTICAL TABS NAVIGATION (DARK NAVY CARD) -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="space-y-1 rounded-2xl p-3 shadow-xl h-fit text-white">
            <button wire:click="setSection('general')" class="w-full text-left px-3.5 py-2.5 rounded-xl font-bold text-xs transition-all flex items-center gap-2.5 {{ $activeSection === 'general' ? 'bg-[#f15153] text-white font-extrabold shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>🏠 General Settings</span>
            </button>
            <button wire:click="setSection('branding')" class="w-full text-left px-3.5 py-2.5 rounded-xl font-bold text-xs transition-all flex items-center gap-2.5 {{ $activeSection === 'branding' ? 'bg-[#f15153] text-white font-extrabold shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>🎨 Branding & Design</span>
            </button>
            <button wire:click="setSection('seo')" class="w-full text-left px-3.5 py-2.5 rounded-xl font-bold text-xs transition-all flex items-center gap-2.5 {{ $activeSection === 'seo' ? 'bg-[#f15153] text-white font-extrabold shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>🔐 SEO Settings</span>
            </button>
            <button wire:click="setSection('payment')" class="w-full text-left px-3.5 py-2.5 rounded-xl font-bold text-xs transition-all flex items-center gap-2.5 {{ $activeSection === 'payment' ? 'bg-[#f15153] text-white font-extrabold shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>💳 Payment Settings</span>
            </button>
            <button wire:click="setSection('email')" class="w-full text-left px-3.5 py-2.5 rounded-xl font-bold text-xs transition-all flex items-center gap-2.5 {{ $activeSection === 'email' ? 'bg-[#f15153] text-white font-extrabold shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>📧 Email & SMS</span>
            </button>
            <a href="{{ route('admin.backups.index') }}" class="w-full text-left px-3.5 py-2.5 rounded-xl font-bold text-xs text-slate-300 hover:bg-slate-800 hover:text-white transition-all flex items-center gap-2.5 text-decoration-none">
                <span>📦 Backup & Restore</span>
            </a>
            <a href="{{ route('admin.activity-logs.index') }}" class="w-full text-left px-3.5 py-2.5 rounded-xl font-bold text-xs text-slate-300 hover:bg-slate-800 hover:text-white transition-all flex items-center gap-2.5 text-decoration-none">
                <span>📋 Activity Logs</span>
            </a>
        </div>

        <!-- MAIN FORM CONTENT (DARK NAVY CARD) -->
        <div class="lg:col-span-3 space-y-6">

            <!-- SECTION 1: GENERAL SETTINGS -->
            @if ($activeSection === 'general')
                <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl p-6 shadow-xl text-white space-y-6">
                    <div class="border-b border-slate-800 pb-4">
                        <h3 class="text-base font-black text-white tracking-tight">General Website Settings</h3>
                        <p class="text-xs text-slate-400 font-medium">Manage platform title, branding assets, localization, and maintenance mode.</p>
                    </div>

                    <form wire:submit.prevent="saveSettings" class="space-y-6 text-xs font-semibold">
                        <div class="space-y-4">
                            <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider">Group 1: Site Information</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-slate-300 mb-1">Site Name</label>
                                    <input type="text" wire:model="site_name" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3);" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-slate-300 mb-1">Site Tagline</label>
                                    <input type="text" wire:model="site_tagline" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3);" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-slate-300 mb-1">Site Description</label>
                                <textarea wire:model="site_description" rows="3" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3);" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none"></textarea>
                            </div>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-slate-800">
                            <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider">Group 2: Contact Information</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-slate-300 mb-1">Support Email</label>
                                    <input type="email" wire:model="support_email" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3);" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-slate-300 mb-1">Support Phone</label>
                                    <input type="text" wire:model="support_phone" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3);" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-start gap-4 pt-4 border-t border-slate-800">
                            <button type="submit" style="background-color: #f15153;" class="px-6 py-3 rounded-xl text-white text-xs font-black shadow-md hover:bg-red-700 transition-all">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- SECTION 2: PAYMENT SETTINGS -->
            @if ($activeSection === 'payment')
                <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl p-6 shadow-xl text-white space-y-6">
                    <div class="border-b border-slate-800 pb-4">
                        <h3 class="text-base font-black text-white tracking-tight">Payment Gateway API Keys</h3>
                        <p class="text-xs text-slate-400 font-medium">Configure credentials for Razorpay and Stripe payment processing.</p>
                    </div>

                    <div class="space-y-6 text-xs font-semibold">
                        <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.25);" class="p-5 rounded-2xl space-y-3">
                            <h4 class="text-xs font-black text-white uppercase">Razorpay Configuration</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-slate-300 mb-1">API Key ID</label>
                                    <input type="text" wire:model="razorpay_key" style="background: #07162C; border: 1px solid rgba(241,81,83,0.3);" class="w-full px-3 py-2 rounded-xl text-white font-mono focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-slate-300 mb-1">API Key Secret</label>
                                    <input type="password" wire:model="razorpay_secret" style="background: #07162C; border: 1px solid rgba(241,81,83,0.3);" class="w-full px-3 py-2 rounded-xl text-white font-mono focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-800">
                            <button type="button" wire:click="saveSettings" style="background-color: #f15153;" class="px-6 py-2.5 rounded-xl text-white text-xs font-black shadow-md">
                                Save Payment Keys
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>
