<div class="space-y-6 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Student Account Settings</h1>
            <p class="text-xs text-slate-300 mt-1">Manage profile information, resume details, and account security.</p>
        </div>
    </div>

    <!-- PROFILE FORM -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 shadow-xl text-white space-y-6">
        <form wire:submit.prevent="saveProfile" class="space-y-6">
            <div class="space-y-4">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider">Personal Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">First Name</label>
                        <input type="text" wire:model="first_name" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Last Name</label>
                        <input type="text" wire:model="last_name" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Email Address</label>
                        <input type="email" wire:model="email" disabled style="background: #07162C; border: 1px solid #1e3a5f; color: #94a3b8;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Phone Number</label>
                        <input type="text" wire:model="phone" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider">Developer Bio & Headline</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Headline</label>
                        <input type="text" wire:model="headline" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">About Me / Bio</label>
                        <textarea wire:model="bio" rows="3" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" wire:loading.attr="disabled" style="background-color: #D62828;" class="px-6 py-3 text-white rounded-xl font-black text-xs shadow-md transition flex items-center gap-2 disabled:opacity-50">
                <span wire:loading.remove>Save Profile Changes</span>
                <span wire:loading class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Saving...
                </span>
            </button>
        </form>
    </div>
</div>
