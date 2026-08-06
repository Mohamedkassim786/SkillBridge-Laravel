<?php

namespace App\Livewire\Public\Jobs;

use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\UserResume;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Job Details - SkillBridge')]
class Show extends Component
{
    public string $id;
    public bool $applied = false;

    public function mount(string $id)
    {
        $this->id = $id;

        $user = auth()->user();
        if ($user) {
            $existing = JobApplication::where('job_posting_id', $this->id)
                ->where('user_id', $user->id)
                ->exists();
            if ($existing) {
                $this->applied = true;
            }
        }
    }

    public function apply()
    {
        $user = auth()->user();
        if (! $user) {
            session()->flash('error', 'Please sign in to apply for this job posting.');
            return redirect()->route('login');
        }

        $job = JobPosting::find($this->id);
        if (! $job) {
            session()->flash('error', 'Job posting not found.');
            return;
        }

        $resume = UserResume::where('user_id', $user->id)->first();
        if (! $resume) {
            $resume = UserResume::create([
                'user_id' => $user->id,
                'title' => 'Default Student Resume.pdf',
                'file_path' => 'resumes/default.pdf',
                'parsed_skills' => ['PHP', 'Laravel', 'JavaScript'],
                'is_default' => true,
            ]);
        }

        JobApplication::firstOrCreate(
            ['job_posting_id' => $job->id, 'user_id' => $user->id],
            [
                'resume_id' => $resume->id,
                'ai_ats_score' => rand(85, 98),
                'status' => 'submitted',
            ]
        );

        $this->applied = true;
        session()->flash('status', "Your application for '{$job->title}' has been submitted successfully to {$job->company?->name}!");
    }

    public function render()
    {
        $job = JobPosting::with('company')->find($this->id);

        if (! $job) {
            $job = JobPosting::with('company')->first();
        }

        $similarJobs = JobPosting::with('company')->where('id', '!=', $job?->id)->take(4)->get();

        return view('livewire.public.jobs.show', [
            'job' => $job,
            'similarJobs' => $similarJobs,
        ]);
    }
}
