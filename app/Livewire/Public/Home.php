<?php

namespace App\Livewire\Public;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\CmsSetting;
use App\Models\Company;
use App\Models\Course;
use App\Models\Faq;
use App\Models\JobPosting;
use App\Models\PublicEvent;
use App\Models\SuccessStory;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Home - Enterprise Software Learning Platform')]
class Home extends Component
{
    public function render()
    {
        $heroHeadline = CmsSetting::get('hero_headline', 'Master Enterprise Software Engineering with Real Code');
        $heroSubheading = CmsSetting::get('hero_subheading', 'Learn full-stack software architecture, domain-driven design, microservices, and modern PHP/Laravel through production projects built by senior engineers.');

        $featuredCourses = Course::with(['category', 'currentVersion', 'trainer'])
            ->take(6)
            ->get();

        $categories = Category::take(8)->get();

        $topTrainers = User::whereIn('role', ['trainer', 'staff', 'admin'])
            ->take(4)
            ->get();

        $successStories = SuccessStory::where('is_featured', true)->take(4)->get();
        $companies = Company::take(6)->get();
        $latestJobs = JobPosting::with('company')->take(4)->get();
        $upcomingEvents = PublicEvent::where('is_upcoming', true)->take(2)->get();
        $latestBlogs = BlogPost::where('is_published', true)->take(3)->get();
        $faqs = Faq::where('is_published', true)->orderBy('sort_order')->take(5)->get();

        return view('livewire.public.home', [
            'heroHeadline' => $heroHeadline,
            'heroSubheading' => $heroSubheading,
            'featuredCourses' => $featuredCourses,
            'categories' => $categories,
            'topTrainers' => $topTrainers,
            'successStories' => $successStories,
            'companies' => $companies,
            'latestJobs' => $latestJobs,
            'upcomingEvents' => $upcomingEvents,
            'latestBlogs' => $latestBlogs,
            'faqs' => $faqs,
        ]);
    }
}
