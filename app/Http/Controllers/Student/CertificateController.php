<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function view(string $id)
    {
        $certificate = Certificate::with(['user', 'courseVersion.course'])->findOrFail($id);

        return view('student.certificates.show', compact('certificate'));
    }

    public function download(string $id)
    {
        $certificate = Certificate::with(['user', 'courseVersion.course'])->findOrFail($id);

        $pdf = Pdf::loadView('student.certificates.pdf', compact('certificate'))
            ->setPaper('a4', 'landscape');

        $filename = 'Certificate_' . str_replace(' ', '_', $certificate->user->name ?? 'Student') . '_' . $certificate->id . '.pdf';

        return $pdf->download($filename);
    }
}
