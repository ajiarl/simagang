<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat Magang — SiMagang</title>

    {{-- Google Fonts: Inter + Material Symbols --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            padding: 24px 16px;
        }
        .container {
            width: 100%;
            max-width: 580px;
        }
        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0px 10px 25px -5px rgba(0, 0, 0, 0.05), 0px 8px 10px -6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.2s ease;
        }
        .card-header {
            padding: 32px 24px 24px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .logo-icon {
            color: #003e7e;
            font-size: 28px;
            display: flex;
            align-items: center;
        }
        .logo-text {
            font-size: 20px;
            font-weight: 800;
            color: #003e7e;
            letter-spacing: -0.02em;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            margin-top: 8px;
        }
        .status-badge.valid {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .status-badge.invalid {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        .status-icon {
            font-size: 20px;
        }
        .card-body {
            padding: 32px 28px;
        }
        .info-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 8px;
        }
        .info-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 28px;
        }
        .info-row {
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: 12px;
            align-items: start;
        }
        .info-label {
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
        }
        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
            line-height: 1.4;
        }
        .grades-table-wrapper {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px;
            margin-top: 12px;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
        }
        .grades-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        .grades-table td {
            font-size: 13px;
            font-weight: 500;
            color: #334155;
            padding: 10px 0;
            border-bottom: 0.5px solid #f1f5f9;
        }
        .grades-table tr:last-child td {
            border-bottom: none;
            padding-bottom: 0;
        }
        .grades-table tr:first-child td {
            padding-top: 12px;
        }
        .score-badge {
            font-weight: 700;
            color: #003e7e;
        }
        .final-score-badge {
            background-color: #003e7e;
            color: #ffffff;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 700;
        }
        .footer-note {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
        }
        .footer-note a {
            color: #003e7e;
            text-decoration: none;
            font-weight: 600;
        }
        .footer-note a:hover {
            text-decoration: underline;
        }

        /* Responsive styling */
        @media (max-width: 480px) {
            .info-row {
                grid-template-columns: 1fr;
                gap: 4px;
            }
            .card-body {
                padding: 24px 16px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="logo-section">
                    <span class="material-symbols-outlined logo-icon">verified</span>
                    <span class="logo-text">SiMagang</span>
                </div>

                @if ($application)
                    <div class="status-badge valid">
                        <span class="material-symbols-outlined status-icon">check_circle</span>
                        Sertifikat Valid
                    </div>
                @else
                    <div class="status-badge invalid">
                        <span class="material-symbols-outlined status-icon">cancel</span>
                        Tidak Valid
                    </div>
                @endif
            </div>

            <div class="card-body">
                @if ($application)
                    <div class="info-title">Detail Verifikasi Sertifikat</div>
                    
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Nama Mahasiswa</div>
                            <div class="info-value">{{ $application->user->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">NIM</div>
                            <div class="info-value">{{ $application->user->nim ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Perusahaan Mitra</div>
                            <div class="info-value">{{ $application->company->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Periode Magang</div>
                            <div class="info-value">{{ $application->internshipPeriod->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Durasi Kerja</div>
                            <div class="info-value">
                                {{ $application->start_date->translatedFormat('d M Y') }} 
                                s/d 
                                {{ $application->end_date->translatedFormat('d M Y') }}
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">No. Sertifikat</div>
                            <div class="info-value" style="font-family: monospace; font-size: 13px;">
                                CERT/{{ sprintf('%04d', $application->id) }}/FIKTI/{{ $application->start_date->format('Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="info-title">Rekapitulasi Penilaian</div>
                    
                    <div class="grades-table-wrapper">
                        <table class="grades-table">
                            <thead>
                                <tr>
                                    <th>Aspek Penilai</th>
                                    <th style="text-align: right;">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nilai Dosen Pembimbing</td>
                                    <td style="text-align: right;" class="score-badge">
                                        {{ $application->assessments->where('assessor_type', 'dosen')->first()?->final_score ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nilai Perusahaan Mitra</td>
                                    <td style="text-align: right;" class="score-badge">
                                        {{ $application->assessments->where('assessor_type', 'perusahaan')->first()?->final_score ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 700; color: #003e7e;">Nilai Akhir (Akumulasi)</td>
                                    <td style="text-align: right;">
                                        <span class="final-score-badge">
                                            {{ $application->combined_score ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 12px 0;">
                        <span class="material-symbols-outlined" style="font-size: 56px; color: #ef4444; margin-bottom: 16px;">warning</span>
                        <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Sertifikat Tidak Terdaftar</h3>
                        <p style="font-size: 14px; color: #64748b; line-height: 1.5;">
                            Kode verifikasi sertifikat tidak valid, tidak ditemukan di server kami, atau status magang mahasiswa yang bersangkutan belum selesai.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <p class="footer-note">
            &copy; {{ date('Y') }} <strong>SiMagang</strong> — Sistem Informasi Manajemen Magang.<br>
            Kembali ke <a href="{{ url('/') }}">Halaman Utama</a>.
        </p>
    </div>

</body>
</html>
