<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\UserResume;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResumeDownloadController extends Controller
{
    public function downloadPdf(Request $request)
    {
        $user = auth()->user();
        $data = session('generated_ats_resume');

        if (!$data) {
            $resume = UserResume::where('user_id', $user?->id)->first();
            if ($resume && $resume->parsed_text) {
                $decoded = json_decode($resume->parsed_text, true);
                if (is_array($decoded)) {
                    $data = $decoded;
                }
            }
        }

        if (!$data) {
            $data = [
                'name' => 'MOHAMED KASSIM M',
                'headline' => 'Computer Science Engineering Student | Full-Stack Developer | AI Enthusiast',
                'phone' => '+91 8610065701',
                'email' => 'haafizkassim786@gmail.com',
                'location' => 'Pudukkottai, Tamil Nadu',
                'linkedin' => 'https://linkedin.com/in/mohamedkassim',
                'github' => 'https://github.com/mohamedkassim786',
                'portfolio' => 'https://mohamedkassim.dev',
                'ats_score' => 96,
                'professional_summary' => 'Motivated CSE student at MIET Engineering College, Trichy with hands-on experience in Full-Stack Web Development, Database Management, and Artificial Intelligence. Built real-world applications including a college ERP system, a live cargo management platform for a Singapore-based company, and an AI-powered academic chatbot. Seeking Software Development Internship to apply and grow technical expertise.',
                'education' => [
                    [
                        'degree' => 'Bachelor of Engineering – Computer Science and Engineering',
                        'institution' => 'MIET Engineering College, Trichy',
                        'cgpa' => 'CGPA: 8.5 / 10',
                        'year' => 'Expected: 2027',
                    ],
                ],
                'technical_skills' => [
                    'Languages' => 'Python, JavaScript, SQL',
                    'Frontend' => 'HTML5, CSS3, React.js',
                    'Backend' => 'Node.js, Express.js, Laravel 12',
                    'Databases' => 'PostgreSQL, MongoDB, MySQL 8',
                    'Tools' => 'Git, GitHub, VS Code, Docker',
                ],
                'projects' => [
                    [
                        'title' => 'MIET ERP Management System',
                        'tech_stack' => 'React.js, Node.js, PostgreSQL',
                        'badge' => 'Ongoing',
                        'bullets' => [
                            'Developing a centralized ERP platform for academic and administrative management at the institution.',
                            'Handles student records, attendance, timetables, and staff management in a unified dashboard.',
                        ],
                    ],
                    [
                        'title' => 'Courier & Cargo Management Website',
                        'tech_stack' => 'React.js, Node.js',
                        'badge' => 'Live Project',
                        'bullets' => [
                            'Designed and deployed a live cargo management platform for a Singapore-based company.',
                            'Features include shipment tracking, order management, and real-time status updates.',
                        ],
                    ],
                    [
                        'title' => 'AI Academic Chatbot',
                        'tech_stack' => 'Python, RAG (Retrieval-Augmented Generation)',
                        'badge' => 'First Prize Winner',
                        'bullets' => [
                            'Developed an AI chatbot to assist students with academic information and query handling.',
                            'Leveraged RAG architecture to retrieve accurate, context-aware answers from academic documents.',
                        ],
                    ],
                ],
                'certifications' => [
                    'Udemy – HTML & CSS Complete Course',
                    'First Prize – AI Chatbot Hackathon',
                    'Best Outreach Award – MIET Engineering College',
                ],
                'soft_skills' => [
                    'Problem Solving',
                    'Team Collaboration',
                    'Communication',
                    'Adaptability',
                    'Quick Learning',
                    'Leadership',
                ],
            ];
        }

        $normalizer = app(\App\Domain\Ai\Resume\ResumeNormalizer::class);
        $data = $normalizer->normalize($data);

        $pdf = Pdf::loadView('pdf.ats-resume', compact('data'))
            ->setPaper('a4', 'portrait');

        $filename = Str::slug($data['name'] ?? 'student') . '-ats-resume.pdf';

        return $pdf->download($filename);
    }
}
