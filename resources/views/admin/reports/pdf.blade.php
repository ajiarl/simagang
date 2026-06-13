<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Magang - {{ $application->user->name }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px;
            color: #191c20;
            line-height: 1.5;
        }
        h1, h2, h3 { color: #0058be; margin-top: 0; }
        .header { text-align: center; border-bottom: 2px solid #0058be; padding-bottom: 10px; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #c2c6d3; padding: 8px; text-align: left; }
        th { background-color: #f8fafc; font-weight: bold; }
        .highlight-box { background-color: #f0f4f8; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: center; border: 1px solid #c2c6d3; }
        .score-large { font-size: 48px; font-weight: bold; color: #0058be; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN AKHIR MAGANG</h1>
        <p>Sistem Informasi Magang Kampus</p>
    </div>

    <div class="section">
        <h3>Biodata Peserta</h3>
        <table>
            <tr><th width="30%">Nama</th><td>{{ $application->user->name }}</td></tr>
            <tr><th>NIM</th><td>{{ $application->user->nim }}</td></tr>
            <tr><th>Jurusan</th><td>{{ $application->user->major ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h3>Informasi Magang</h3>
        <table>
            <tr><th width="30%">Perusahaan</th><td>{{ $application->company->name }}</td></tr>
            <tr><th>Periode Magang</th><td>{{ \Carbon\Carbon::parse($application->start_date)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($application->end_date)->format('d M Y') }}</td></tr>
            <tr><th>Dosen Pembimbing</th><td>{{ $application->dosen->name ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h3>Rekapitulasi Kehadiran</h3>
        <table>
            <tr>
                <th style="text-align: center;">Hadir</th>
                <th style="text-align: center;">Tidak Hadir (Izin/Sakit/Alpa)</th>
            </tr>
            <tr>
                <td style="text-align: center; font-size: 18px; font-weight: bold;">{{ $totalPresent }} Hari</td>
                <td style="text-align: center; font-size: 18px; font-weight: bold;">{{ $totalAbsent }} Hari</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Rekapitulasi Penilaian</h3>
        @if($finalScore)
            <table>
                <tr>
                    <th width="40%">Aspek Penilaian</th>
                    <th>Nilai Dosen (50%)</th>
                    <th>Nilai Perusahaan (50%)</th>
                </tr>
                <tr>
                    <td>Kedisiplinan</td>
                    <td>{{ $dosenAssessment->discipline }}</td>
                    <td>{{ $perusahaanAssessment->discipline }}</td>
                </tr>
                <tr>
                    <td>Sikap & Perilaku</td>
                    <td>{{ $dosenAssessment->attitude }}</td>
                    <td>{{ $perusahaanAssessment->attitude }}</td>
                </tr>
                <tr>
                    <td>Kemampuan Teknis</td>
                    <td>{{ $dosenAssessment->skills }}</td>
                    <td>{{ $perusahaanAssessment->skills }}</td>
                </tr>
                <tr>
                    <td>Komunikasi</td>
                    <td>{{ $dosenAssessment->communication }}</td>
                    <td>{{ $perusahaanAssessment->communication }}</td>
                </tr>
                <tr>
                    <td>Inisiatif</td>
                    <td>{{ $dosenAssessment->initiative }}</td>
                    <td>{{ $perusahaanAssessment->initiative }}</td>
                </tr>
                <tr>
                    <th style="text-align: right;">Rata-Rata</th>
                    <th>{{ $dosenAssessment->final_score }}</th>
                    <th>{{ $perusahaanAssessment->final_score }}</th>
                </tr>
            </table>

            <div class="highlight-box">
                <div style="font-size: 16px; color: #424751;">Nilai Akhir Magang</div>
                <div class="score-large">{{ $finalScore }}</div>
            </div>
            
            @if($dosenAssessment->notes || $perusahaanAssessment->notes)
                <div style="margin-top: 20px;">
                    <p><strong>Catatan Dosen:</strong> {{ $dosenAssessment->notes ?: '-' }}</p>
                    <p><strong>Catatan Perusahaan:</strong> {{ $perusahaanAssessment->notes ?: '-' }}</p>
                </div>
            @endif
        @else
            <p style="color: #ba1a1a;">Penilaian belum lengkap dari Dosen dan/atau Perusahaan.</p>
        @endif
    </div>
</body>
</html>
