<?php

namespace App\Livewire\Student\Practice;

use App\Domain\Ai\Interview\Services\VoiceInterviewSessionService;
use App\Models\JobPosting;
use App\Models\MockInterview;
use App\Models\UserResume;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

use Livewire\WithFileUploads;

#[Layout('components.layouts.student')]
#[Title('AI Real-Time Voice Mock Interview - SkillBridge')]
class MockInterviews extends Component
{
    use WithFileUploads;

    // Interview Configuration Inputs
    public string $selectedRole = 'Laravel Developer';
    public string $interviewType = 'technical'; // hr, technical, behavioral, resume_based, job_specific, full_mock
    public string $experienceLevel = '0-1 Years'; // fresher, 0-1, 1-3, 3-5, 5+
    public int $difficulty = 3; // 1-5 (1: Beginner, 3: Intermediate, 5: Advanced)
    public ?string $selectedResumeId = null;
    public ?string $selectedJobId = null;
    public $resumeFile = null;

    public array $rolesList = [
        'Laravel Developer',
        'Full Stack Developer',
        'React Developer',
        'Python Developer',
        'Java Developer',
        'Backend Developer',
        'Frontend Developer',
        'Software Engineer',
        'DevOps Engineer',
        'Data Analyst',
        'QA Engineer',
        'AI/ML Engineer',
    ];

    public function updatedResumeFile()
    {
        $this->validate([
            'resumeFile' => 'required|file|mimes:pdf|max:10240',
        ]);

        $path = $this->resumeFile->store('resumes', 'public');
        $fullPath = storage_path('app/public/' . $path);

        $parsedText = '';
        try {
            if (class_exists(\Smalot\PdfParser\Parser::class)) {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($fullPath);
                $parsedText = $pdf->getText();
            }
        } catch (\Throwable $e) {
            $parsedText = "Parsed resume file: " . $this->resumeFile->getClientOriginalName();
        }

        // Extract skills
        $knownSkills = ['PHP', 'Laravel', 'Python', 'C++', 'Java', 'JavaScript', 'React', 'Vue', 'Node.js', 'ROS', 'ROS2', 'OpenCV', 'SQL', 'MySQL', 'PostgreSQL', 'Redis', 'Docker', 'Git', 'AWS', 'Linux', 'REST API', 'GraphQL', 'Tailwind', 'HTML', 'CSS'];
        $foundSkills = [];
        foreach ($knownSkills as $skill) {
            if (stripos($parsedText, $skill) !== false) {
                $foundSkills[] = $skill;
            }
        }

        $title = pathinfo($this->resumeFile->getClientOriginalName(), PATHINFO_FILENAME);

        $resume = UserResume::create([
            'user_id' => auth()->id(),
            'title' => $title,
            'file_path' => $path,
            'parsed_text' => $parsedText,
            'parsed_skills' => array_values(array_unique($foundSkills)),
            'is_default' => false,
        ]);

        $this->selectedResumeId = $resume->id;
        $this->interviewType = 'resume_based';
        session()->flash('resume_success', 'Resume uploaded & analyzed successfully!');
    }

    public function startInterview(VoiceInterviewSessionService $sessionService)
    {
        $this->validate([
            'selectedRole' => 'required|string',
            'interviewType' => 'required|string',
            'experienceLevel' => 'required|string',
            'difficulty' => 'required|integer|min:1|max:5',
        ]);

        $interview = $sessionService->createSession(
            userId: auth()->id(),
            role: $this->selectedRole,
            interviewType: $this->interviewType,
            experienceLevel: $this->experienceLevel,
            difficulty: $this->difficulty,
            resumeId: $this->selectedResumeId,
            jobId: $this->selectedJobId
        );

        return redirect()->route('student.practice.mock.room', ['id' => $interview->id]);
    }

    public function render()
    {
        $pastInterviews = MockInterview::where('student_id', auth()->id())
            ->with(['questions', 'report'])
            ->orderBy('created_at', 'desc')
            ->get();

        $resumes = UserResume::where('user_id', auth()->id())->get();
        $jobs = JobPosting::latest()->take(10)->get();

        return view('livewire.student.practice.mock-interviews', array_merge(get_object_vars($this), [
            'pastInterviews' => $pastInterviews,
            'resumes' => $resumes,
            'jobs' => $jobs,
        ]));
    }
}
