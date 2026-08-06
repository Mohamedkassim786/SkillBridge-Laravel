<?php

namespace App\Livewire\Student\Settings;

use App\Models\User;
use App\Models\UserResume;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('My Profile & Settings - SkillBridge')]
class Index extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public string $headline = '';
    public string $bio = '';
    public string $github_url = '';
    public string $linkedin_url = '';

    public function mount()
    {
        $user = auth()->user();
        if ($user) {
            $this->first_name = $user->first_name ?? $user->name;
            $this->last_name = $user->last_name ?? '';
            $this->email = $user->email ?? '';
            $this->phone = $user->phone ?? '+91 98765 43210';
            $this->headline = $user->headline ?? 'Full-Stack Developer Student';
            $this->bio = $user->bio ?? 'Aspiring software engineer learning enterprise Laravel 12 and Livewire 3 architecture.';
        }
    }

    public function saveProfile()
    {
        $user = auth()->user();
        if ($user) {
            $user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'name' => trim($this->first_name . ' ' . $this->last_name),
                'phone' => $this->phone,
            ]);

            session()->flash('status', 'Student profile details updated successfully! ✅');
        }
    }

    public function render()
    {
        $resume = UserResume::where('user_id', auth()->id())->first();

        return view('livewire.student.settings.index', compact('resume'));
    }
}
