<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\CmsSetting;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\PublicEvent;
use App\Models\SuccessStory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CMS Settings
        $settings = [
            'hero_headline' => 'Master Enterprise Software Engineering with Real Code',
            'hero_subheading' => 'Learn full-stack software architecture, domain-driven design, microservices, and modern PHP/Laravel through production projects built by senior engineers.',
            'hero_cta_primary_text' => 'Explore Courses',
            'hero_cta_primary_url' => '/courses',
            'hero_cta_secondary_text' => 'Watch Live Preview',
            'hero_cta_secondary_url' => '/events',
            'site_name' => 'SkillBridge LMS',
            'site_phone' => '+1 (800) 555-SKILL',
            'site_email' => 'support@skillbridge.io',
            'site_address' => '100 Silicon Valley Way, Suite 400, San Francisco, CA 94107',
            'footer_about' => 'SkillBridge is an enterprise-grade software learning platform connecting engineers to production architecture, live mentorship, and verified career placements.',
        ];

        foreach ($settings as $key => $val) {
            CmsSetting::set($key, $val);
        }

        // 2. Pricing Plans
        $plans = [
            [
                'title' => 'Free Starter',
                'slug' => 'free-starter',
                'monthly_price' => 0,
                'yearly_price' => 0,
                'badge' => 'Beginners',
                'cta_text' => 'Get Started Free',
                'is_popular' => false,
                'sort_order' => 1,
                'features' => [
                    'Access to 5 Free Preview Courses',
                    'Community Discord & Forum Access',
                    'Standard Video Playback',
                    'Course Quizzes & Assessments',
                ],
            ],
            [
                'title' => 'Pro Architect',
                'slug' => 'pro-architect',
                'monthly_price' => 49.00,
                'yearly_price' => 399.00,
                'badge' => 'Most Popular',
                'cta_text' => 'Start Pro Membership',
                'is_popular' => true,
                'sort_order' => 2,
                'features' => [
                    'Unlimited Access to All Enterprise Courses',
                    'Source Code GitHub Repositories',
                    '1-on-1 Code Reviews & Mentorship',
                    'Verified Completion Certificates',
                    'Direct Job Application Referral',
                ],
            ],
            [
                'title' => 'Enterprise Team',
                'slug' => 'enterprise-team',
                'monthly_price' => 149.00,
                'yearly_price' => 1299.00,
                'badge' => 'Corporate Teams',
                'cta_text' => 'Contact Sales',
                'is_popular' => false,
                'sort_order' => 3,
                'features' => [
                    'Up to 10 Engineer Accounts',
                    'Dedicated Technical Mentor',
                    'Custom Team Curriculum Paths',
                    'Corporate Billing & Invoice Support',
                    '24/7 Priority SLA Support',
                ],
            ],
        ];

        foreach ($plans as $p) {
            PricingPlan::firstOrCreate(['slug' => $p['slug']], $p);
        }

        // 3. Success Stories
        $stories = [
            [
                'student_name' => 'Alex Rivera',
                'job_title' => 'Senior Full-Stack Engineer',
                'company_name' => 'TechCorp Global',
                'salary_package' => '$145,000 / yr',
                'course_title' => 'Full-Stack Software Architecture with Laravel 12',
                'testimonial' => 'The production architecture lessons gave me the exact confidence needed to pass senior system design interviews.',
                'linkedin_url' => 'https://linkedin.com/in/alex-rivera-demo',
                'is_featured' => true,
            ],
            [
                'student_name' => 'Priya Sharma',
                'job_title' => 'Backend API Architect',
                'company_name' => 'FinTech Systems',
                'salary_package' => '22 LPA',
                'course_title' => 'Enterprise REST & Microservices Masterclass',
                'testimonial' => 'SkillBridge taught me real repository patterns and Redis caching techniques used in high-throughput banking apps.',
                'linkedin_url' => 'https://linkedin.com/in/priya-sharma-demo',
                'is_featured' => true,
            ],
        ];

        foreach ($stories as $s) {
            SuccessStory::firstOrCreate(['student_name' => $s['student_name']], $s);
        }

        // 4. Blog Posts
        $posts = [
            [
                'title' => 'Building High-Throughput REST APIs with Laravel 12 & Redis',
                'slug' => 'building-high-throughput-rest-apis-laravel-12-redis',
                'excerpt' => 'Learn how to optimize database indexing, pipeline Redis cache buffers, and handle 10,000 requests per second in modern PHP 8.3 applications.',
                'content' => 'In enterprise web development, scalability is governed by how efficiently your backend application communicates with database persistence layers. In this article, we explore how Laravel 12 leverages modern PHP 8.3 features and Redis pipeline caching...',
                'category' => 'Backend Engineering',
                'author_name' => 'Dr. Marcus Vance',
                'read_time_mins' => 6,
                'views_count' => 1420,
            ],
            [
                'title' => 'Mastering Livewire 3 Reactive State and Alpine.js Directives',
                'slug' => 'mastering-livewire-3-reactive-state-alpinejs',
                'excerpt' => 'Eliminate network bottlenecks by keeping local DOM state fast with Alpine.js while syncing server state seamlessly with Livewire 3.',
                'content' => 'Single Page Application reactivity no longer requires heavy JavaScript frameworks like React or Vue. Livewire 3 provides server-driven reactive state while offloading UI transitions to Alpine.js...',
                'category' => 'Frontend Architecture',
                'author_name' => 'Sarah Jenkins',
                'read_time_mins' => 8,
                'views_count' => 2100,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::firstOrCreate(['slug' => $post['slug']], $post);
        }

        // 5. Public Events
        $events = [
            [
                'title' => 'Live Q&A: Enterprise Microservices & Domain Events in Laravel 12',
                'slug' => 'live-qa-enterprise-microservices-laravel-12',
                'event_type' => 'Live Webinar',
                'instructor_name' => 'Dr. Marcus Vance',
                'starts_at' => now()->addDays(2),
                'duration_mins' => 60,
                'meeting_url' => 'https://meet.google.com/skillbridge-demo',
                'description' => 'Join our senior architects for a live breakdown of event-driven microservices architecture using Laravel 12.',
                'is_upcoming' => true,
            ],
            [
                'title' => 'Live Code Review: Optimizing MySQL Queries & Index Strategies',
                'slug' => 'live-code-review-mysql-query-optimization',
                'event_type' => 'Live Workshop',
                'instructor_name' => 'Sarah Jenkins',
                'starts_at' => now()->addDays(5),
                'duration_mins' => 90,
                'meeting_url' => 'https://meet.google.com/skillbridge-mysql',
                'description' => 'Interactive session analyzing slow EXPLAIN query logs and building composite indexes for large database tables.',
                'is_upcoming' => true,
            ],
        ];

        foreach ($events as $ev) {
            PublicEvent::firstOrCreate(['slug' => $ev['slug']], $ev);
        }

        // 6. FAQs
        $faqs = [
            [
                'question' => 'How long do I have access to course materials?',
                'answer' => 'When you enroll in any course or Pro plan, you get lifetime access to all video lessons, code repositories, downloadable resources, and future course updates.',
                'category' => 'General',
                'sort_order' => 1,
            ],
            [
                'question' => 'Are certificates officially verifiable by recruiters?',
                'answer' => 'Yes! Every certificate issued by SkillBridge includes a unique credential UUID and SHA-256 tamper-proof hash that employers can verify directly on our platform.',
                'category' => 'Certificates',
                'sort_order' => 2,
            ],
            [
                'question' => 'Can I cancel or downgrade my subscription at any time?',
                'answer' => 'Absolutely. You can manage or cancel your subscription anytime directly from your Account Settings with zero hidden fees.',
                'category' => 'Pricing',
                'sort_order' => 3,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
