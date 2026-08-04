<div>
    <div class="mb-6">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#0B1F3A] text-xs font-semibold mb-2">
            Step 2 of 2: Profile Onboarding
        </div>
        <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Complete Your Profile</h2>
        <p class="mt-1.5 text-sm text-slate-600">Provide your education and skills to personalize your SkillBridge learning journey.</p>
    </div>

    <form wire:submit="saveProfile" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="education" class="block text-sm font-semibold text-slate-800">Highest Education *</label>
                <input wire:model="education" id="education" type="text" required
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('education') border-rose-500 @enderror"
                       placeholder="e.g. B.S. Computer Science">
                @error('education') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="date_of_birth" class="block text-sm font-semibold text-slate-800">Date of Birth</label>
                <input wire:model="date_of_birth" id="date_of_birth" type="date"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="gender" class="block text-sm font-semibold text-slate-800">Gender</label>
                <select wire:model="gender" id="gender"
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Non-Binary">Non-Binary</option>
                    <option value="Prefer not to say">Prefer not to say</option>
                </select>
            </div>

            <div>
                <label for="skills_input" class="block text-sm font-semibold text-slate-800">Key Skills (Comma Separated)</label>
                <input wire:model="skills_input" id="skills_input" type="text"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm"
                       placeholder="PHP, Laravel, JavaScript, SQL">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="city" class="block text-sm font-semibold text-slate-800">City</label>
                <input wire:model="city" id="city" type="text"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm"
                       placeholder="San Francisco">
            </div>

            <div>
                <label for="country" class="block text-sm font-semibold text-slate-800">Country</label>
                <input wire:model="country" id="country" type="text"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm"
                       placeholder="United States">
            </div>
        </div>

        <div>
            <label for="bio" class="block text-sm font-semibold text-slate-800">Bio / About You</label>
            <textarea wire:model="bio" id="bio" rows="2"
                      class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm"
                      placeholder="Aspiring full-stack software engineer interested in enterprise web apps."></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="linkedin_url" class="block text-sm font-semibold text-slate-800">LinkedIn Profile URL</label>
                <input wire:model="linkedin_url" id="linkedin_url" type="url"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm"
                       placeholder="https://linkedin.com/in/username">
            </div>

            <div>
                <label for="github_url" class="block text-sm font-semibold text-slate-800">GitHub Profile URL (Optional)</label>
                <input wire:model="github_url" id="github_url" type="url"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm"
                       placeholder="https://github.com/username">
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" wire:loading.attr="disabled"
                    class="w-full py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-lg shadow-[#D62828]/25 transition-all flex items-center justify-center gap-2">
                <span wire:loading.remove>Save & Continue to Dashboard</span>
                <span wire:loading>Saving Profile...</span>
            </button>
        </div>
    </form>
</div>
