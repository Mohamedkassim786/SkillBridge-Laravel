<?php

namespace App\Livewire\Student\Career;

use App\Models\InterviewSchedule;
use App\Models\JobPosting;
use App\Models\SavedJob;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Saved Jobs & Interview Schedules - SkillBridge')]
class SavedJobs extends Component
{
    public bool $jobAlertsEnabled = true;

    public function toggleJobAlerts()
    {
        $this->jobAlertsEnabled = ! $this->jobAlertsEnabled;
        session()->flash('status', $this->jobAlertsEnabled ? 'Job alert email notifications enabled! 🔔' : 'Job alert notifications muted.');
    }

    public function removeSavedJob(string $savedId)
    {
        SavedJob::where('user_id', auth()->id())->where('id', $savedId)->delete();
        session()->flash('status', 'Job removed from saved list.');
    }

    public function render()
    {
        $userId = auth()->id();

        $savedJobs = SavedJob::with('jobPosting.company')
            ->where('user_id', $userId)
            ->get();

        if ($savedJobs->isEmpty()) {
            // Seed a sample saved job for demonstration
            $job = JobPosting::first();
            if ($job) {
                SavedJob::firstOrCreate(['user_id' => $userId, 'job_posting_id' => $job->id]);
                $savedJobs = SavedJob::with('jobPosting.company')->where('user_id', $userId)->get();
            }
        }

        $interviews = InterviewSchedule::where('user_id', $userId)
            ->orderBy('scheduled_at', 'asc')
            ->get();

        if ($interviews->isEmpty()) {
            InterviewSchedule::create([
                'user_id' => $userId,
                'company_name' => 'Tata Consultancy Services',
                'job_title' => 'Senior Laravel Engineer',
                'scheduled_at' => now()->addDays(2)->setHour(14)->setMinute(30),
                'type' => 'System Design & Technical Round',
                'meeting_link' => 'https://meet.jit.si/skillbridge-interview-tcs',
                'status' => 'scheduled',
            ]);
            $interviews = InterviewSchedule::where('user_id', $userId)->get();
        }

        return view('livewire.student.career.saved-jobs', compact('savedJobs', 'interviews'));
    }
}
