<?php

namespace App\Livewire\Auth;

use App\Domain\Auth\Services\ProfileCompletionService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Profile Settings - SkillBridge')]
class ProfileSettings extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public ?string $date_of_birth = '';
    public ?string $gender = '';
    public ?string $education = '';
    public ?string $headline = '';
    public ?string $bio = '';
    public string $skills_input = '';
    public ?string $linkedin_url = '';
    public ?string $github_url = '';
    public int $completion_percentage = 0;

    public function mount()
    {
        $user = auth()->user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';

        $profile = $user->profile;
        if ($profile) {
            $this->date_of_birth = $profile->date_of_birth?->format('Y-m-d') ?? '';
            $this->gender = $profile->gender ?? '';
            $this->education = $profile->education ?? '';
            $this->headline = $profile->headline ?? '';
            $this->bio = $profile->bio ?? '';
            $this->skills_input = is_array($profile->skills) ? implode(', ', $profile->skills) : '';
            $this->linkedin_url = $profile->linkedin_url ?? '';
            $this->github_url = $profile->github_url ?? '';
            $this->completion_percentage = $profile->profile_completion_percentage ?? 0;
        }
    }

    public function updateProfile(ProfileCompletionService $completionService)
    {
        $user = auth()->user();

        $this->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'linkedin_url' => ['nullable', 'url'],
            'github_url' => ['nullable', 'url'],
        ]);

        $user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $skillsArray = array_filter(array_map('trim', explode(',', $this->skills_input)));

        $profile = $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'date_of_birth' => $this->date_of_birth ?: null,
                'gender' => $this->gender ?: null,
                'education' => $this->education,
                'headline' => $this->headline,
                'bio' => $this->bio,
                'skills' => $skillsArray,
                'linkedin_url' => $this->linkedin_url,
                'github_url' => $this->github_url,
            ]
        );

        $this->completion_percentage = $completionService->calculateAndUpdate($profile);

        session()->flash('status', 'Profile settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.auth.profile-settings');
    }
}
