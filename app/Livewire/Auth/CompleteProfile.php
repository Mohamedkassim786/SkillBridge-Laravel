<?php

namespace App\Livewire\Auth;

use App\Domain\Auth\Services\ProfileCompletionService;
use App\Domain\Auth\Services\RoleRedirectionService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Complete Student Profile - SkillBridge')]
class CompleteProfile extends Component
{
    public ?string $date_of_birth = '';
    public ?string $gender = '';
    public ?string $education = '';
    public ?string $address = '';
    public ?string $city = '';
    public ?string $state = '';
    public ?string $country = '';
    public ?string $postal_code = '';
    public ?string $headline = '';
    public ?string $bio = '';
    public string $skills_input = '';
    public ?string $linkedin_url = '';
    public ?string $github_url = '';

    public function mount()
    {
        $profile = auth()->user()?->profile;
        if ($profile) {
            $this->date_of_birth = $profile->date_of_birth?->format('Y-m-d') ?? '';
            $this->gender = $profile->gender ?? '';
            $this->education = $profile->education ?? '';
            $this->address = $profile->address ?? '';
            $this->city = $profile->city ?? '';
            $this->state = $profile->state ?? '';
            $this->country = $profile->country ?? '';
            $this->postal_code = $profile->postal_code ?? '';
            $this->headline = $profile->headline ?? '';
            $this->bio = $profile->bio ?? '';
            $this->skills_input = is_array($profile->skills) ? implode(', ', $profile->skills) : '';
            $this->linkedin_url = $profile->linkedin_url ?? '';
            $this->github_url = $profile->github_url ?? '';
        }
    }

    public function saveProfile(ProfileCompletionService $completionService, RoleRedirectionService $roleService)
    {
        $this->validate([
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string'],
            'education' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'linkedin_url' => ['nullable', 'url'],
            'github_url' => ['nullable', 'url'],
        ]);

        $user = auth()->user();
        $skillsArray = array_filter(array_map('trim', explode(',', $this->skills_input)));

        $profile = $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'date_of_birth' => $this->date_of_birth ?: null,
                'gender' => $this->gender ?: null,
                'education' => $this->education,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'country' => $this->country,
                'postal_code' => $this->postal_code,
                'headline' => $this->headline,
                'bio' => $this->bio,
                'skills' => $skillsArray,
                'linkedin_url' => $this->linkedin_url,
                'github_url' => $this->github_url,
            ]
        );

        $completionService->calculateAndUpdate($profile);

        return redirect()->intended($roleService->getRedirectPath($user))
            ->with('status', 'Profile completed successfully!');
    }

    public function render()
    {
        return view('livewire.auth.complete-profile');
    }
}
