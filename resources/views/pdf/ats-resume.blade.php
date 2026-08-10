<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['name'] ?? 'Candidate' }} - ATS Resume</title>
    <style>
        @page {
            margin: 30pt 40pt;
        }
        body {
            font-family: 'Times New Roman', Times, Georgia, serif;
            color: #000000;
            font-size: 10pt;
            line-height: 1.35;
            background-color: #ffffff;
        }
        .header {
            text-align: center;
            margin-bottom: 8pt;
        }
        .name {
            font-size: 22pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1pt;
            margin: 0;
            line-height: 1;
        }
        .headline {
            font-size: 10.5pt;
            font-style: italic;
            margin-top: 4pt;
            color: #111111;
            font-weight: 600;
        }
        .contact {
            font-size: 9pt;
            margin-top: 4pt;
            color: #222222;
        }
        .contact a {
            color: #000000;
            text-decoration: underline;
        }
        .section-header {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            border-top: 1.5pt solid #000000;
            padding-top: 3pt;
            margin-top: 12pt;
            margin-bottom: 6pt;
            letter-spacing: 0.5pt;
        }
        .summary-text {
            text-align: justify;
            font-size: 9.5pt;
            line-height: 1.4;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4pt;
        }
        .item-table td {
            padding: 0;
            vertical-align: top;
        }
        .left-col {
            font-weight: bold;
            font-size: 10pt;
            text-align: left;
        }
        .right-col {
            font-style: italic;
            font-size: 9.5pt;
            text-align: right;
            white-space: nowrap;
        }
        .sub-row {
            font-size: 9.5pt;
            margin-top: 1.5pt;
            margin-bottom: 4pt;
        }
        .skills-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin-top: 2pt;
        }
        .skills-table td {
            padding: 2pt 0;
            vertical-align: top;
        }
        .skill-cat {
            font-weight: bold;
            width: 22%;
        }
        .skill-val {
            width: 78%;
        }
        ul.dash-bullets {
            margin: 3pt 0 6pt 16pt;
            padding: 0;
            list-style-type: disc;
        }
        ul.dash-bullets li {
            margin-bottom: 2.5pt;
            font-size: 9.5pt;
            text-align: justify;
            line-height: 1.35;
        }
        ul.cert-bullets {
            margin: 3pt 0 4pt 16pt;
            padding: 0;
            list-style-type: disc;
        }
        ul.cert-bullets li {
            margin-bottom: 2pt;
            font-size: 9.5pt;
        }
        .soft-skills-line {
            font-size: 9.5pt;
            text-align: left;
            margin-top: 3pt;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <!-- HEADER SECTION -->
    <div class="header">
        <div class="name">{{ $data['name'] ?? 'CANDIDATE NAME' }}</div>
        @if (!empty($data['headline']))
            <div class="headline">{{ $data['headline'] }}</div>
        @endif
        <div class="contact">
            {{ $data['phone'] ?? '' }}
            @if (!empty($data['email'])) | {{ $data['email'] }} @endif
            @if (!empty($data['location'])) | {{ $data['location'] }} @endif
            @if (!empty($data['linkedin'])) | <a href="{{ $data['linkedin'] }}">LinkedIn</a> @endif
            @if (!empty($data['github'])) | <a href="{{ $data['github'] }}">GitHub</a> @endif
            @if (!empty($data['portfolio'])) | <a href="{{ $data['portfolio'] }}">Portfolio</a> @endif
        </div>
    </div>

    <!-- PROFESSIONAL SUMMARY -->
    @if (!empty($data['professional_summary']))
        <div class="section-header">PROFESSIONAL SUMMARY</div>
        <div class="summary-text">
            {{ $data['professional_summary'] }}
        </div>
    @endif

    <!-- EDUCATION -->
    @if (!empty($data['education']))
        <div class="section-header">EDUCATION</div>
        @foreach ($data['education'] as $edu)
            <table class="item-table">
                <tr>
                    <td class="left-col">{{ $edu['degree'] ?? '' }}</td>
                    <td class="right-col">{{ !empty($edu['year']) && !str_contains($edu['degree'] ?? '', $edu['year']) ? $edu['year'] : '' }}</td>
                </tr>
            </table>
            @if (!empty($edu['institution']) && strtolower(trim($edu['institution'])) !== 'engineering college' && !str_contains($edu['degree'] ?? '', $edu['institution']))
                <div class="sub-row">
                    {{ $edu['institution'] }}
                    @if (!empty($edu['cgpa']) && !str_contains($edu['degree'] ?? '', $edu['cgpa'])) | <strong>{{ $edu['cgpa'] }}</strong> @endif
                </div>
            @endif
        @endforeach
    @endif

    <!-- TECHNICAL SKILLS -->
    @if (!empty($data['technical_skills']))
        <div class="section-header">TECHNICAL SKILLS</div>
        <table class="skills-table">
            @foreach ($data['technical_skills'] as $cat => $val)
                @php
                    $valStr = is_array($val) ? implode(', ', $val) : $val;
                @endphp
                @if (!empty(trim($valStr)) && strtolower(trim($valStr)) !== 'none' && strtolower(trim($valStr)) !== 'n/a')
                    <tr>
                        <td class="skill-cat">{{ is_numeric($cat) || strtolower($cat) === 'skills' ? 'Technical Skills:' : (str_contains($cat, ':') ? $cat : $cat . ':') }}</td>
                        <td class="skill-val">{{ $valStr }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    @endif

    <!-- WORK EXPERIENCE -->
    @if (!empty($data['work_experience']) && count($data['work_experience']) > 0)
        <div class="section-header">WORK EXPERIENCE</div>
        @foreach ($data['work_experience'] as $exp)
            <table class="item-table">
                <tr>
                    <td class="left-col">
                        {{ $exp['title'] ?? '' }}
                        @if (!empty($exp['company'])) — <span style="font-weight: normal;">{{ $exp['company'] }}</span> @endif
                        @if (!empty($exp['employment_type']) && strtolower($exp['employment_type']) !== 'full-time')
                            <span style="font-size: 8.5pt; font-style: italic; color: #444444;">({{ $exp['employment_type'] }})</span>
                        @endif
                    </td>
                    <td class="right-col">{{ $exp['period'] ?? '' }}</td>
                </tr>
            </table>
            @if (!empty($exp['location']))
                <div class="sub-row" style="font-style: italic; font-size: 9pt;">{{ $exp['location'] }}</div>
            @endif
            @if (!empty($exp['bullets']))
                <ul class="dash-bullets">
                    @foreach ($exp['bullets'] as $bullet)
                        <li>{{ $bullet }}</li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    @endif

    <!-- PROJECTS -->
    @if (!empty($data['projects']))
        <div class="section-header">PROJECTS</div>
        @foreach ($data['projects'] as $proj)
            <table class="item-table">
                <tr>
                    <td class="left-col">
                        {{ $proj['title'] ?? 'Project Name' }}
                        @if (!empty($proj['tech_stack'])) — <span style="font-weight: normal;">{{ $proj['tech_stack'] }}</span> @endif
                    </td>
                    @if (!empty($proj['badge']))
                        <td class="right-col">{{ $proj['badge'] }}</td>
                    @endif
                </tr>
            </table>
            @if (!empty($proj['bullets']))
                <ul class="dash-bullets">
                    @foreach ($proj['bullets'] as $bullet)
                        <li>{{ $bullet }}</li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    @endif

    <!-- CERTIFICATIONS & ACHIEVEMENTS -->
    @php
        $validCerts = array_filter($data['certifications'] ?? [], function($c) {
            return !empty(trim($c)) && strtolower(trim($c)) !== 'no certifications listed';
        });
    @endphp
    @if (count($validCerts) > 0)
        <div class="section-header">CERTIFICATIONS & ACHIEVEMENTS</div>
        <ul class="cert-bullets">
            @foreach ($validCerts as $cert)
                <li>{{ $cert }}</li>
            @endforeach
        </ul>
    @endif

    <!-- SOFT SKILLS -->
    @php
        $validSoft = array_filter(is_array($data['soft_skills'] ?? []) ? $data['soft_skills'] : explode(',', $data['soft_skills'] ?? ''), function($s) {
            return !empty(trim($s));
        });
    @endphp
    @if (count($validSoft) > 0)
        <div class="section-header">SOFT SKILLS</div>
        <div class="soft-skills-line">
            {{ implode('   •   ', array_map('trim', $validSoft)) }}
        </div>
    @endif

</body>
</html>
