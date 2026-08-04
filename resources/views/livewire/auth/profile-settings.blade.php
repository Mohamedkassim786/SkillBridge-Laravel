<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Profile Settings</h2>
            <p class="mt-1 text-sm text-slate-600">Update your personal account details and public student metadata.</p>
        </div>
        <!-- Profile Completion Badge -->
        <div class="text-right">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Completion Score</div>
            <div class="text-2xl font-extrabold text-[#D62828]">{{ $completion_percentage }}%</div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="w-full bg-slate-200 h-2 rounded-full mb-6 overflow-hidden">
        <div class="bg-[#D62828] h-full transition-all duration-500" style="width: {{ $completion_percentage }}%"></div>
    </div>

    <form wire:submit="updateProfile" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-semibold text-slate-800">First Name</label>
                <input wire:model="first_name" id="first_name" type="text" required
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 text-sm">
            </div>
            <div>
                <label for="last_name" class="block text-sm font-semibold text-slate-800">Last Name</label>
                <input wire:model="last_name" id="last_name" type="text" required
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-800">Email Address</label>
                <input wire:model="email" id="email" type="email" required
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 text-sm">
            </div>
            <div>
                <label for="phone" class="block text-sm font-semibold text-slate-800">Phone Number</label>
                <input wire:model="phone" id="phone" type="tel"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 text-sm">
            </div>
        </div>

        <div>
            <label for="education" class="block text-sm font-semibold text-slate-800">Education</label>
            <input wire:model="education" id="education" type="text"
                   class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 text-sm">
        </div>

        <div>
            <label for="headline" class="block text-sm font-semibold text-slate-800">Professional Headline</label>
            <input wire:model="headline" id="headline" type="text"
                   class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 text-sm"
                   placeholder="e.g. Junior Web Developer">
        </div>

        <div>
            <label for="bio" class="block text-sm font-semibold text-slate-800">Bio</label>
            <textarea wire:model="bio" id="bio" rows="3"
                      class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 text-sm"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="linkedin_url" class="block text-sm font-semibold text-slate-800">LinkedIn URL</label>
                <input wire:model="linkedin_url" id="linkedin_url" type="url"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 text-sm">
            </div>
            <div>
                <label for="github_url" class="block text-sm font-semibold text-slate-800">GitHub URL</label>
                <input wire:model="github_url" id="github_url" type="url"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 text-sm">
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-md transition-all">
                Save Changes
            </button>
        </div>
    </form>
</div>
