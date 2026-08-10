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
            font-family: 'Georgia', 'Times New Roman', Times, serif;
            color: #111111;
            font-size: 10.5pt;
            line-height: 1.48;
            background-color: #ffffff;
        }
        .header {
            border-bottom: 1.5pt solid #111111;
            padding-bottom: 6pt;
            margin-bottom: 14pt;
        }
        .name {
            font-size: 20pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
            margin: 0;
            line-height: 1;
        }
        .contact {
            font-size: 9.5pt;
            margin-top: 5pt;
            color: #333333;
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
        .letter-paragraph {
            margin-bottom: 10pt;
            font-size: 10.5pt;
            text-align: justify;
            text-justify: inter-word;
        }
        .highlights-title {
            font-weight: bold;
            margin-top: 12pt;
            margin-bottom: 4pt;
            text-transform: uppercase;
            font-size: 9.5pt;
            letter-spacing: 0.5pt;
            color: #111111;
        }
        ul.bullet-list {
            margin: 2pt 0 12pt 16pt;
            padding: 0;
            list-style-type: disc;
        }
        ul.bullet-list li {
            margin-bottom: 3pt;
            font-size: 10pt;
            color: #222222;
        }
        .signature {
            margin-top: 18pt;
            font-size: 10.5pt;
        }
        .signature .sig-name {
            font-weight: bold;
            margin-top: 18pt;
            font-size: 11pt;
        }
    </style>
</head>
<body>

    <!-- HEADER SECTION -->
    <div class="header">
        <div class="name">{{ $data['name'] ?? 'Candidate Name' }}</div>
        <div class="contact">
            @php
                $contactParts = array_filter([$data['email'] ?? '', $data['phone'] ?? '', $data['location'] ?? '']);
            @endphp
            {{ implode('  |  ', $contactParts) }}
        </div>
    </div>

    <!-- DATE -->
    <div class="date-line">{{ $data['date'] ?? date('F d, Y') }}</div>

    <!-- RECIPIENT -->
    <div class="recipient">
        <div>{{ $data['hiring_manager'] ?? 'Hiring Manager / Talent Acquisition Team' }}</div>
        <div class="company">{{ $data['company_name'] ?? 'Target Company' }}</div>
    </div>

    <!-- LETTER BODY -->
    <div class="letter-body">
        @if (!empty($data['opening']))
            <div class="greeting">{{ $data['greeting'] ?? 'Dear Hiring Manager,' }}</div>
            <br>
            <div class="letter-paragraph">{{ $data['opening'] }}</div>
            @if (!empty($data['experience_paragraph']))
                <div class="letter-paragraph">{{ $data['experience_paragraph'] }}</div>
            @endif
            @if (!empty($data['fit_paragraph']))
                <div class="letter-paragraph">{{ $data['fit_paragraph'] }}</div>
            @endif
            @if (!empty($data['closing_paragraph']))
                <div class="letter-paragraph">{{ $data['closing_paragraph'] }}</div>
            @endif
        @else
            <div class="letter-paragraph" style="white-space: pre-line;">{{ $data['letter_body'] ?? '' }}</div>
        @endif
    </div>

    <!-- KEY CORE QUALIFICATIONS -->
    @if (!empty($data['highlights']) && is_array($data['highlights']) && count($data['highlights']) > 0)
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
        <div class="sig-name">{{ $data['signature'] ?? ($data['name'] ?? 'Candidate Name') }}</div>
    </div>

</body>
</html>
