<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion</title>
    <style>
        @page { margin: 0px; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
            margin: 0;
            padding: 40px;
        }
        .border-container {
            border: 8px double #d97706;
            padding: 40px;
            height: 85%;
            position: relative;
        }
        .header {
            text-align: center;
        }
        .brand {
            font-size: 11px;
            font-weight: bold;
            color: #d97706;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .title {
            font-size: 32px;
            font-weight: 900;
            color: #0b1f3a;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }
        .subtitle {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .student-name {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #d62828;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 2px solid #fde68a;
            padding-bottom: 10px;
        }
        .body-text {
            text-align: center;
            font-size: 13px;
            color: #475569;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .course-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #0b1f3a;
            margin-top: 10px;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-td {
            width: 33%;
            vertical-align: middle;
        }
        .date-title {
            font-size: 10px;
            color: #94a3b8;
            font-weight: bold;
            text-transform: uppercase;
        }
        .date-val {
            font-size: 13px;
            font-weight: bold;
            color: #0b1f3a;
            margin-top: 4px;
        }
        .seal-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #d97706;
            color: #ffffff;
            text-align: center;
            line-height: 70px;
            font-size: 12px;
            font-weight: bold;
            margin: 0 auto;
        }
        .hash-title {
            font-size: 9px;
            color: #94a3b8;
            text-transform: uppercase;
            text-align: right;
        }
        .hash-val {
            font-size: 9px;
            font-family: monospace;
            color: #475569;
            text-align: right;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="border-container">
        <div class="header">
            <div class="brand">SkillBridge Enterprise LMS • Official Credential</div>
            <div class="title">Certificate of Completion</div>
            <div class="subtitle">This official credential certifies that</div>
        </div>

        <div class="student-name">
            {{ $certificate->user?->name ?? 'Student' }}
        </div>

        <div class="body-text">
            has successfully completed all requirements, practical assessments, and curriculum modules for the course:
        </div>

        <div class="course-title">
            {{ $certificate->course?->title ?? 'Full-Stack Software Architecture' }}
        </div>

        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td class="footer-td">
                        <div class="date-title">Date Issued</div>
                        <div class="date-val">
                            {{ $certificate->issued_at ? \Carbon\Carbon::parse($certificate->issued_at)->format('F d, Y') : now()->format('F d, Y') }}
                        </div>
                    </td>
                    <td class="footer-td">
                        <div class="seal-circle">VERIFIED</div>
                    </td>
                    <td class="footer-td">
                        <div class="hash-title">Credential UUID</div>
                        <div class="hash-val">{{ $certificate->uuid }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
