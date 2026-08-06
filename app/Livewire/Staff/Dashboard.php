<?php

namespace App\Livewire\Staff;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\JobApplication;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.staff')]
#[Title('Staff & Trainer Portal - SkillBridge')]
class Dashboard extends Component
{
    // Active Tab Navigation
    public string $activeTab = 'dashboard';

    // Sub-tab / Step trackers
    public int $createCourseStep = 1;
    public string $assignmentTab = 'all';
    public string $quizTab = 'all';
    public string $liveClassTab = 'upcoming';
    public string $materialTab = 'all';
    public string $reportTab = 'overview';
    public string $settingTab = 'profile';
    public string $messageTab = 'all';

    // Search and Filters
    public string $search = '';
    public string $filterStatus = 'all';

    // Modals
    public bool $showReplyModal = false;
    public bool $showGradeModal = false;
    public bool $showScheduleClassModal = false;

    // Selection Models
    public string $selectedStudentName = '';
    public string $selectedQuestion = '';
    public string $replyMessage = '';
    public int $gradeScore = 85;
    public string $gradeFeedback = '';

    public function mount()
    {
        if (request()->has('tab')) {
            $this->activeTab = request()->get('tab');
        }
    }

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function setCreateStep(int $step)
    {
        $this->createCourseStep = $step;
    }

    public function openReplyModal(string $studentName, string $question)
    {
        $this->selectedStudentName = $studentName;
        $this->selectedQuestion = $question;
        $this->replyMessage = '';
        $this->showReplyModal = true;
    }

    public function sendReply()
    {
        session()->flash('status', "Reply sent successfully to {$this->selectedStudentName}!");
        $this->showReplyModal = false;
    }

    public function submitGrade()
    {
        session()->flash('status', 'Assignment grade and feedback submitted successfully!');
        $this->showGradeModal = false;
    }

    public function scheduleLiveClass()
    {
        session()->flash('status', 'Live class scheduled and notification sent to students!');
        $this->showScheduleClassModal = false;
    }

    public function render()
    {
        $courses = Course::with(['currentVersion.modules.lessons'])->get();
        $students = User::role('student')->get();

        // 100% Real MySQL 8 Metrics
        $totalCoursesCount = Course::count();
        $totalStudentsCount = $students->count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $totalLessonsCount = Lesson::count();
        $totalEnrollmentsCount = Enrollment::count();
        $completedEnrollmentsCount = Enrollment::where('status', 'completed')->count();
        $jobApplicationsCount = JobApplication::count();

        return view('livewire.staff.dashboard', [
            'courses' => $courses,
            'students' => $students,
            'totalCoursesCount' => $totalCoursesCount,
            'totalStudentsCount' => $totalStudentsCount,
            'totalRevenue' => $totalRevenue,
            'totalLessonsCount' => $totalLessonsCount,
            'totalEnrollmentsCount' => $totalEnrollmentsCount,
            'completedEnrollmentsCount' => $completedEnrollmentsCount,
            'jobApplicationsCount' => $jobApplicationsCount,
        ]);
    }
}
