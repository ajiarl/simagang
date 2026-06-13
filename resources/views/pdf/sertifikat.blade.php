<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Magang - {{ $application->user->name }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}') format('truetype');
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 11pt;
            color: #1a1a2e;
            background: #ffffff;
        }

        /* Outer double border */
        .outer-border {
            position: fixed;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 3px solid #003e7e;
        }

        .inner-border {
            position: fixed;
            top: 16px;
            left: 16px;
            right: 16px;
            bottom: 16px;
            border: 1px solid #003e7e;
        }

        .page {
            padding: 55px 65px;
            min-height: 100%;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 8px;
        }

        .logo-text {
            font-size: 22pt;
            font-weight: bold;
            color: #003e7e;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .logo-sub {
            font-size: 10pt;
            color: #555;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        .header-divider {
            border: none;
            border-top: 2px solid #003e7e;
            margin: 12px 0 6px;
        }

        .header-divider-thin {
            border: none;
            border-top: 1px solid #0058be;
            margin: 4px 0 16px;
        }

        /* Title */
        .cert-title {
            text-align: center;
            margin-bottom: 6px;
        }

        .cert-title h1 {
            font-size: 26pt;
            color: #003e7e;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .cert-subtitle {
            font-size: 10pt;
            color: #555;
            text-align: center;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }

        /* Body */
        .body-section {
            text-align: center;
            margin-bottom: 6px;
        }

        .label-given {
            font-size: 11pt;
            color: #424751;
            margin-bottom: 10px;
        }

        .student-name {
            font-size: 24pt;
            font-weight: bold;
            color: #003e7e;
            margin: 6px 0;
            letter-spacing: 1px;
        }

        .student-nim {
            font-size: 11pt;
            color: #555;
            margin-bottom: 20px;
        }

        .completion-text {
            font-size: 11pt;
            color: #424751;
            margin-bottom: 8px;
        }

        .company-name {
            font-size: 16pt;
            font-weight: bold;
            color: #1a56a0;
            margin-bottom: 14px;
        }

        .period-info {
            font-size: 10pt;
            color: #555;
            margin-bottom: 4px;
        }

        .date-info {
            font-size: 10pt;
            color: #555;
            margin-bottom: 24px;
        }

        /* Decorative center line */
        .deco-line {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 18px auto;
            width: 60%;
        }

        .deco-line::before,
        .deco-line::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #c2c6d3;
        }

        .deco-diamond {
            padding: 0 10px;
            color: #003e7e;
            font-size: 14pt;
        }

        /* Nilai section */
        .nilai-section {
            margin: 8px auto 28px;
            width: 90%;
        }

        .nilai-title {
            text-align: center;
            font-size: 10pt;
            color: #737782;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .nilai-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .nilai-grid td {
            width: 33.33%;
            text-align: center;
            padding: 12px 8px;
            border: 1px solid #e2e2e9;
            background: #f3f3fa;
        }

        .nilai-label {
            font-size: 9pt;
            color: #737782;
            display: block;
            margin-bottom: 4px;
        }

        .nilai-value {
            font-size: 14pt;
            font-weight: bold;
            color: #003e7e;
        }

        .nilai-akhir-cell {
            background: #003e7e !important;
        }

        .nilai-akhir-cell .nilai-label {
            color: rgba(255,255,255,0.8);
        }

        .nilai-akhir-cell .nilai-value {
            color: #ffffff;
            font-size: 18pt;
        }

        /* Footer */
        .footer {
            margin-top: 10px;
        }

        .footer-date {
            text-align: right;
            font-size: 10pt;
            color: #555;
            margin-bottom: 50px;
        }

        .signature-area {
            width: 100%;
        }

        .signature-area td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
        }

        .sig-title {
            font-size: 10pt;
            color: #424751;
            margin-bottom: 60px;
        }

        .sig-name {
            font-size: 10pt;
            font-weight: bold;
            color: #191c20;
            text-decoration: underline;
        }

        .sig-nip {
            font-size: 9pt;
            color: #737782;
            margin-top: 2px;
        }

        .cert-number {
            text-align: center;
            font-size: 9pt;
            color: #737782;
            margin-top: 16px;
            border-top: 1px solid #e2e2e9;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <!-- Double border decorations -->
    <div class="outer-border"></div>
    <div class="inner-border"></div>

    <div class="page">

        <!-- Header / Kop -->
        <div class="header">
            <div class="logo-text">SiMagang</div>
            <div class="logo-sub">Sistem Informasi Manajemen Magang</div>
            <div class="logo-sub" style="font-size:9pt; color:#777;">Universitas SiMagang Teknologi &mdash; Fakultas Ilmu Komputer dan Teknologi Informasi</div>
        </div>

        <hr class="header-divider">
        <hr class="header-divider-thin">

        <!-- Certificate Title -->
        <div class="cert-title">
            <h1>Sertifikat Magang</h1>
        </div>
        <div class="cert-subtitle">Certificate of Internship Completion</div>

        <!-- Body -->
        <div class="body-section">
            <p class="label-given">Diberikan kepada:</p>

            <div class="student-name">{{ $application->user->name }}</div>
            <div class="student-nim">NIM: {{ $application->user->nim ?? '-' }}</div>

            <p class="completion-text">Telah menyelesaikan program magang di:</p>

            <div class="company-name">{{ $application->company->name }}</div>

            <p class="period-info">
                Periode: <strong>{{ $application->internshipPeriod->name }}</strong>
            </p>
            <p class="date-info">
                Tanggal:
                {{ $application->start_date->format('d M Y') }}
                &ndash;
                {{ $application->end_date->format('d M Y') }}
            </p>
        </div>

        <!-- Decorative divider -->
        <table style="width:60%; margin:0 auto 18px; border-collapse:collapse;">
            <tr>
                <td style="border-bottom:1px solid #c2c6d3; width:45%;"></td>
                <td style="text-align:center; color:#003e7e; font-size:14pt; padding:0 8px; white-space:nowrap;">&#9670;</td>
                <td style="border-bottom:1px solid #c2c6d3; width:45%;"></td>
            </tr>
        </table>

        <!-- Nilai Section -->
        <div class="nilai-section">
            <div class="nilai-title">Rekapitulasi Nilai</div>
            <table class="nilai-grid">
                <tr>
                    <td>
                        <span class="nilai-label">Nilai Dosen Pembimbing</span>
                        <span class="nilai-value">{{ $nilaiDosen ?? '-' }}</span>
                    </td>
                    <td>
                        <span class="nilai-label">Nilai Perusahaan</span>
                        <span class="nilai-value">{{ $nilaiPerusahaan ?? '-' }}</span>
                    </td>
                    <td class="nilai-akhir-cell">
                        <span class="nilai-label">Nilai Akhir</span>
                        <span class="nilai-value">{{ $nilaiAkhir ?? '-' }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-date">
                Dikeluarkan pada: Kota Cerdas, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>

            <table class="signature-area">
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <p class="sig-title">Admin Program Studi,</p>
                        <p class="sig-name">Admin Program Studi</p>
                        <p class="sig-nip">Program Studi Teknik Informatika</p>
                        <p class="sig-nip">Universitas SiMagang Teknologi</p>
                    </td>
                </tr>
            </table>

            <div class="cert-number">
                No. Sertifikat: CERT/{{ sprintf('%04d', $application->id) }}/FIKTI/{{ date('Y') }}
                &nbsp;&bull;&nbsp;
                Dicetak melalui SiMagang &mdash; Sistem Informasi Manajemen Magang
            </div>
        </div>

    </div>

</body>
</html>
