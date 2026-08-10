<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CoverLetterDownloadController extends Controller
{
    public function downloadPdf(Request $request)
    {
        $user = auth()->user();
        $data = session('generated_cover_letter');

        if (!$data || empty($data['letter_body'])) {
            $data = [
                'name' => $user?->name ?? 'Demo Student',
                'email' => $user?->email ?? 'student@skillbridge.com',
                'phone' => '+91 8610065701',
                'location' => 'Pudukkottai, Tamil Nadu',
                'target_role' => 'Full Stack Developer',
                'company_name' => 'Cognizant',
                'hiring_manager' => 'Hiring Manager / Talent Acquisition Team',
                'greeting' => 'Dear Hiring Manager,',
                'opening' => 'I am writing to express my interest in the Full Stack Developer position at Cognizant. As a Computer Science student with hands-on experience developing web applications, I am eager to apply my software development skills in a professional environment.',
                'experience_paragraph' => 'Through my project work, I have gained practical experience with React.js, Node.js, Express.js, PostgreSQL, and MongoDB. I have developed an online learning management system involving authentication, REST APIs, database integration, and responsive frontend development. These projects have strengthened my understanding of both frontend and backend development.',
                'fit_paragraph' => 'I enjoy solving practical programming problems and learning new technologies. I would welcome the opportunity to contribute my technical skills, project experience, and willingness to learn to Cognizant\'s development team.',
                'closing_paragraph' => 'Thank you for considering my application. I would appreciate the opportunity to discuss how my background and skills could contribute to the role.',
                'letter_body' => "Dear Hiring Manager,\n\nI am writing to express my interest in the Full Stack Developer position at Cognizant. As a Computer Science student with hands-on experience developing web applications, I am eager to apply my software development skills in a professional environment.\n\nThrough my project work, I have gained practical experience with React.js, Node.js, Express.js, PostgreSQL, and MongoDB. I have developed an online learning management system involving authentication, REST APIs, database integration, and responsive frontend development. These projects have strengthened my understanding of both frontend and backend development.\n\nI enjoy solving practical programming problems and learning new technologies. I would welcome the opportunity to contribute my technical skills, project experience, and willingness to learn to Cognizant's development team.\n\nThank you for considering my application. I would appreciate the opportunity to discuss how my background and skills could contribute to the role.\n\nSincerely,\nDemo Student",
                'highlights' => [
                    "React.js and Node.js web development experience",
                    "REST API development and database integration",
                    "MongoDB and PostgreSQL database experience",
                    "Full-stack project experience",
                ],
                'signature' => $user?->name ?? 'Demo Student',
                'date' => date('F d, Y'),
            ];
        }

        $pdf = Pdf::loadView('pdf.cover-letter', compact('data'))
            ->setPaper('a4', 'portrait');

        $filename = Str::slug($data['name'] ?? 'student') . '-cover-letter.pdf';

        return $pdf->download($filename);
    }
}
