<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Company;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Invoice;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobPosting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserResume;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        $student = User::where('email', 'student@skillbridge.com')->first();
        $admin = User::where('email', 'admin@skillbridge.com')->first();
        $staff = User::where('email', 'staff@skillbridge.com')->first();

        // 1. Seed Top Companies
        $companies = [
            [
                'name' => 'Google Cloud India',
                'slug' => 'google-cloud-india',
                'logo_path' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg',
                'website' => 'https://cloud.google.com',
                'tax_id' => 'GSTIN33AAACG1234A1Z1',
                'billing_email' => 'billing@google.com',
                'description' => 'Global leader in cloud infrastructure, AI models, and enterprise software scaling.',
                'is_verified' => true,
            ],
            [
                'name' => 'Microsoft Tech Labs',
                'slug' => 'microsoft-tech-labs',
                'logo_path' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg',
                'website' => 'https://microsoft.com',
                'tax_id' => 'GSTIN33AAACM5678B1Z2',
                'billing_email' => 'accounts@microsoft.com',
                'description' => 'Empowering developers worldwide with Azure cloud, .NET runtime, and AI tools.',
                'is_verified' => true,
            ],
            [
                'name' => 'Amazon Web Services',
                'slug' => 'amazon-web-services',
                'logo_path' => 'https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg',
                'website' => 'https://aws.amazon.com',
                'tax_id' => 'GSTIN33AAACA9012C1Z3',
                'billing_email' => 'finance@amazon.com',
                'description' => 'Pioneer in distributed cloud computing, storage solutions, and serverless compute.',
                'is_verified' => true,
            ],
            [
                'name' => 'Infosys Innovations',
                'slug' => 'infosys-innovations',
                'logo_path' => 'https://upload.wikimedia.org/wikipedia/commons/9/95/Infosys_logo.svg',
                'website' => 'https://infosys.com',
                'tax_id' => 'GSTIN33AAACI3456D1Z4',
                'billing_email' => 'careers@infosys.com',
                'description' => 'Next-generation digital services and IT consulting for Fortune 500 enterprises.',
                'is_verified' => true,
            ],
        ];

        $createdCompanies = [];
        foreach ($companies as $compData) {
            $createdCompanies[] = Company::firstOrCreate(['slug' => $compData['slug']], $compData);
        }

        // 2. Seed Job Categories & Job Postings
        $webCat = JobCategory::firstOrCreate(['slug' => 'backend-development'], ['name' => 'Backend Engineering']);
        $frontendCat = JobCategory::firstOrCreate(['slug' => 'frontend-engineering'], ['name' => 'Frontend Engineering']);

        $jobs = [
            [
                'company_id' => $createdCompanies[0]->id,
                'category_id' => $webCat->id,
                'title' => 'Senior Full-Stack Software Engineer (Laravel / React)',
                'slug' => 'senior-full-stack-software-engineer-laravel-react',
                'location' => 'Bengaluru, Karnataka (Hybrid)',
                'salary_min' => 1800000,
                'salary_max' => 2800000,
                'status' => 'active',
                'source' => 'internal',
                'description' => 'Looking for an experienced engineer skilled in Domain Driven Design, Laravel REST APIs, and Livewire / React single page applications.',
            ],
            [
                'company_id' => $createdCompanies[1]->id,
                'category_id' => $frontendCat->id,
                'title' => 'Lead Frontend Architect (Tailwind / Livewire / Vue)',
                'slug' => 'lead-frontend-architect-tailwind-livewire-vue',
                'location' => 'Hyderabad, Telangana (Remote)',
                'salary_min' => 2000000,
                'salary_max' => 3200000,
                'status' => 'active',
                'source' => 'internal',
                'description' => 'Build reactive design systems and high performance frontends for cloud applications.',
            ],
            [
                'company_id' => $createdCompanies[2]->id,
                'category_id' => $webCat->id,
                'title' => 'DevOps & Microservices Cloud Architect',
                'slug' => 'devops-microservices-cloud-architect',
                'location' => 'Chennai, Tamil Nadu',
                'salary_min' => 2200000,
                'salary_max' => 3500000,
                'status' => 'active',
                'source' => 'internal',
                'description' => 'Manage Kubernetes clusters, CI/CD pipelines, and high-throughput AWS infrastructure.',
            ],
        ];

        $createdJobs = [];
        foreach ($jobs as $jData) {
            $createdJobs[] = JobPosting::firstOrCreate(['slug' => $jData['slug']], $jData);
        }

        // 3. Seed Student Resume & Job Application
        if ($student && ! empty($createdJobs)) {
            $resume = UserResume::firstOrCreate(
                ['user_id' => $student->id, 'title' => 'Software Developer Resume 2026.pdf'],
                [
                    'file_path' => 'resumes/student_resume.pdf',
                    'parsed_text' => 'Full Stack Developer proficient in PHP, Laravel 12, Livewire 3, MySQL 8, and REST API design.',
                    'parsed_skills' => ['PHP', 'Laravel', 'Livewire', 'MySQL', 'REST API'],
                    'is_default' => true,
                ]
            );

            JobApplication::firstOrCreate(
                ['job_posting_id' => $createdJobs[0]->id, 'user_id' => $student->id],
                [
                    'resume_id' => $resume->id,
                    'ai_ats_score' => 92,
                    'status' => 'shortlisted',
                ]
            );
        }

        // 4. Seed Orders, OrderItems, Invoices, and Payments
        $course = Course::with('currentVersion')->first();
        if ($student && $course && $course->currentVersion) {
            $order = Order::firstOrCreate(
                ['order_number' => 'ORD-2026-98124'],
                [
                    'user_id' => $student->id,
                    'subtotal' => 99.00,
                    'discount_amount' => 0.00,
                    'tax_amount' => 0.00,
                    'total_amount' => 99.00,
                    'currency' => 'INR',
                    'status' => 'paid',
                ]
            );

            OrderItem::firstOrCreate(
                ['order_id' => $order->id, 'course_version_id' => $course->currentVersion->id],
                ['unit_price' => 99.00]
            );

            Invoice::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'invoice_number' => 'INV-2026-98124',
                    'net_amount' => 99.00,
                    'tax_amount' => 0.00,
                    'gross_amount' => 99.00,
                    'pdf_url' => 'invoices/INV-2026-98124.pdf',
                ]
            );

            Payment::firstOrCreate(
                ['transaction_id' => 'pay_rzp_live_9876543210'],
                [
                    'order_id' => $order->id,
                    'gateway' => 'razorpay',
                    'amount' => 99.00,
                    'currency' => 'INR',
                    'status' => 'completed',
                    'gateway_response' => ['status' => 'captured', 'method' => 'upi', 'bank' => 'HDFC'],
                ]
            );
        }

        // 5. Seed Course Reviews
        if ($student && $course) {
            CourseReview::firstOrCreate(
                ['user_id' => $student->id, 'course_id' => $course->id],
                [
                    'rating' => 5,
                    'review_text' => 'Outstanding course! The real repository pattern and Livewire 3 architecture lessons were exactly what I needed for production.',
                ]
            );
        }

        // 6. Seed System Audit Logs
        $auditLogs = [
            ['user_id' => $admin?->id, 'action' => 'user.login', 'ip_address' => '127.0.0.1', 'metadata' => ['browser' => 'Chrome 122', 'os' => 'Windows 11']],
            ['user_id' => $staff?->id, 'action' => 'course.create', 'ip_address' => '127.0.0.1', 'metadata' => ['title' => 'Laravel 12 REST API Architecture']],
            ['user_id' => $student?->id, 'action' => 'course.enroll', 'ip_address' => '127.0.0.1', 'metadata' => ['course_id' => $course?->id]],
            ['user_id' => $admin?->id, 'action' => 'system.backup', 'ip_address' => '127.0.0.1', 'metadata' => ['filename' => 'backup_2026_08_06.sql']],
        ];

        foreach ($auditLogs as $log) {
            AuditLog::create($log);
        }

        // 7. Seed Contact Messages
        ContactMessage::firstOrCreate(
            ['email' => 'priya.sharma@techcorp.io'],
            [
                'name' => 'Priya Sharma',
                'phone' => '+91 98765 12345',
                'subject' => 'Enterprise Corporate Training Inquiry',
                'message' => 'Hello SkillBridge team, we would like to enroll 25 software engineers into your Advanced Full Stack Laravel & Livewire program.',
                'status' => 'unread',
            ]
        );
    }
}
