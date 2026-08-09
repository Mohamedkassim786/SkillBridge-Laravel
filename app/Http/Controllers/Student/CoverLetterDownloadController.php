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

        if (!$data) {
            $data = [
                'name' => $user?->name ?? 'MOHAMED KASSIM M',
                'email' => $user?->email ?? 'haafizkassim786@gmail.com',
                'phone' => '+91 8610065701',
                'location' => 'Pudukkottai, Tamil Nadu',
                'target_role' => 'Software Development Intern',
                'company_name' => 'Singapore Logistics Corp',
                'hiring_manager' => 'Hiring Manager / Talent Acquisition Team',
                'date' => date('F d, Y'),
                'letter_body' => "Dear Hiring Team at Singapore Logistics Corp,\n\nI am writing to express my strong interest in the Software Development Intern position. With hands-on experience developing Full-Stack web applications using Python, React.js, Node.js, PostgreSQL, and RAG AI Architecture, I am confident in my ability to contribute value immediately.\n\nThroughout my practical project work at MIET Engineering College, I have built a centralized ERP Management System, deployed a live Cargo & Courier tracking website for a Singapore client, and developed an award-winning RAG AI Academic Chatbot. I thrive in collaborative engineering environments where code quality and performance are top priorities.\n\nThank you for considering my application. I look forward to discussing how my technical background aligns with Singapore Logistics Corp's engineering goals.\n\nSincerely,\nMOHAMED KASSIM M",
                'highlights' => [
                    "Proven proficiency in Python, React.js, Node.js, PostgreSQL, and RAG AI Architecture",
                    "Hands-on experience building live production cargo tracking applications",
                    "Strong foundation in enterprise web architecture and database optimization",
                ],
            ];
        }

        $pdf = Pdf::loadView('pdf.cover-letter', compact('data'))
            ->setPaper('a4', 'portrait');

        $filename = Str::slug($data['name'] ?? 'student') . '-cover-letter.pdf';

        return $pdf->download($filename);
    }
}
