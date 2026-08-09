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
        $certificate = Certificate::with(['user', 'courseVersion.course.category'])->findOrFail($id);

        return view('student.certificates.show', compact('certificate'));
    }

    public function download(string $id)
    {
        $certificate = Certificate::with(['user', 'courseVersion.course.category'])->findOrFail($id);

        $verifyUrl = route('certificates.verify', $certificate->uuid ?? $certificate->id);
        $qrBase64 = null;

        try {
            $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=" . urlencode($verifyUrl);
            $ctx = stream_context_create([
                'http' => ['timeout' => 3],
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
            ]);
            $imgData = @file_get_contents($qrApiUrl, false, $ctx);
            if ($imgData) {
                $qrBase64 = 'data:image/png;base64,' . base64_encode($imgData);
            }
        } catch (\Throwable $e) {
        }

        $pdf = Pdf::loadView('student.certificates.pdf', compact('certificate', 'qrBase64', 'verifyUrl'))
            ->setPaper('a4', 'landscape')
            ->setOption([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'dpi' => 96,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'SkillBridge_Certificate_' . str_replace(' ', '_', $certificate->user->name ?? 'Student') . '_' . substr($certificate->id, 0, 8) . '.pdf';

        return $pdf->download($filename);
    }

    public function verifyPublic(string $uuid)
    {
        $certificate = Certificate::with(['user', 'courseVersion.course.category'])
            ->where('uuid', $uuid)
            ->orWhere('id', $uuid)
            ->firstOrFail();

        return view('student.certificates.verify', compact('certificate'));
    }
}
