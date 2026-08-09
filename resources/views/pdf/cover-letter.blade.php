<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['name'] ?? 'Candidate' }} - Cover Letter</title>
    <style>
        @page {
            margin: 40pt 45pt;
        }
        body {
            font-family: 'Times New Roman', Times, Georgia, serif;
            color: #000000;
            font-size: 10.5pt;
            line-height: 1.45;
            background-color: #ffffff;
        }
        .header {
            border-bottom: 1.5pt solid #000000;
            padding-bottom: 6pt;
            margin-bottom: 14pt;
        }
        .name {
            font-size: 22pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
            margin: 0;
            line-height: 1;
        }
        .contact {
            font-size: 9.5pt;
            margin-top: 5pt;
            color: #222222;
        }
        .date-line {
            margin-top: 14pt;
            margin-bottom: 14pt;
            font-weight: bold;
            font-size: 10pt;
        }
        .recipient {
            margin-bottom: 16pt;
            line-height: 1.35;
            font-size: 10pt;
        }
        .recipient .company {
            font-weight: bold;
        }
        .letter-body {
            text-align: left;
            margin-bottom: 16pt;
            white-space: pre-line;
            font-size: 10pt;
            line-height: 1.5;
        }
        .highlights-title {
            font-weight: bold;
            margin-top: 10pt;
            margin-bottom: 4pt;
            text-transform: uppercase;
            font-size: 9.5pt;
            letter-spacing: 0.5pt;
        }
        ul.bullet-list {
            margin: 2pt 0 14pt 16pt;
            padding: 0;
            list-style-type: disc;
        }
        ul.bullet-list li {
            margin-bottom: 2.5pt;
            font-size: 9.5pt;
        }
        .signature {
            margin-top: 20pt;
            font-size: 10pt;
        }
        .signature .sig-name {
            font-weight: bold;
            margin-top: 20pt;
            font-size: 10.5pt;
        }
    </style>
</head>
<body>

    <!-- HEADER SECTION -->
    <div class="header">
        <div class="name">{{ $data['name'] ?? 'MOHAMED KASSIM M' }}</div>
        <div class="contact">
            {{ $data['email'] ?? 'haafizkassim786@gmail.com' }} | 
            {{ $data['phone'] ?? '+91 8610065701' }} | 
            {{ $data['location'] ?? 'Pudukkottai, Tamil Nadu' }}
        </div>
    </div>

    <!-- DATE -->
    <div class="date-line">{{ $data['date'] ?? date('F d, Y') }}</div>

    <!-- RECIPIENT -->
    <div class="recipient">
        <div>{{ $data['hiring_manager'] ?? 'Hiring Manager / Talent Acquisition Team' }}</div>
        <div class="company">{{ $data['company_name'] ?? 'Target Enterprise Company' }}</div>
    </div>

    <!-- LETTER BODY -->
    <div class="letter-body">
{{ $data['letter_body'] ?? "Dear Hiring Manager,\n\nI am writing to express my strong interest in the position at {$data['company_name']}.\n\nThank you for your time and consideration." }}
    </div>

    <!-- KEY HIGHLIGHTS -->
    @if (!empty($data['highlights']))
        <div class="highlights-title">KEY CORE QUALIFICATIONS</div>
        <ul class="bullet-list">
            @foreach ($data['highlights'] as $highlight)
                <li>{{ $highlight }}</li>
            @endforeach
        </ul>
    @endif

    <!-- SIGNATURE -->
    <div class="signature">
        <div>Sincerely,</div>
        <div class="sig-name">{{ $data['name'] ?? 'MOHAMED KASSIM M' }}</div>
    </div>

</body>
</html>
