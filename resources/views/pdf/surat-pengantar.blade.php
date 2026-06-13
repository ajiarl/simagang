<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pengantar Magang</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }
        .kop-surat p {
            margin: 0;
            font-size: 11pt;
        }
        .content {
            margin-top: 20px;
        }
        .signature {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 250px;
        }
        .signature-space {
            height: 80px;
        }
        table.info-table {
            width: 100%;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        table.info-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        .td-label {
            width: 150px;
        }
        .td-colon {
            width: 20px;
            text-align: center;
        }
        table.student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        table.student-table th, table.student-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>UNIVERSITAS SIMAGANG TEKNOLOGI</h2>
        <p>Fakultas Ilmu Komputer dan Teknologi Informasi</p>
        <p>Jl. Pendidikan No. 123, Kota Cerdas, Indonesia</p>
        <p>Telp: (021) 1234567 | Email: info@simagang.test | Web: www.simagang.test</p>
    </div>

    <div class="content">
        <div style="float: right;">
            Kota Cerdas, {{ \Carbon\Carbon::parse($application->approved_at)->translatedFormat('d F Y') }}
        </div>
        <div style="clear: both;"></div>

        <table class="info-table">
            <tr>
                <td class="td-label">Nomor</td>
                <td class="td-colon">:</td>
                <td>{{ sprintf('%03d', $application->id) }}/FIKTI/SMG/{{ date('Y') }}</td>
            </tr>
            <tr>
                <td class="td-label">Lampiran</td>
                <td class="td-colon">:</td>
                <td>1 (satu) berkas</td>
            </tr>
            <tr>
                <td class="td-label">Perihal</td>
                <td class="td-colon">:</td>
                <td><strong>Permohonan Tempat Magang / Praktik Kerja Lapangan (PKL)</strong></td>
            </tr>
        </table>

        <p style="margin-top: 30px;">
            Yth. <strong>Pimpinan {{ $application->company->name }}</strong><br>
            {{ $application->company->address ?? 'Di Tempat' }}<br>
            {{ $application->company->city ?? '' }}
        </p>

        <p style="text-indent: 30px; text-align: justify;">
            Dengan hormat,
        </p>
        <p style="text-indent: 30px; text-align: justify;">
            Dalam rangka pemenuhan kurikulum program S1 dan peningkatan kompetensi mahasiswa di lingkungan Fakultas Ilmu Komputer dan Teknologi Informasi, Universitas SiMagang Teknologi, kami memohon kesediaan Bapak/Ibu untuk dapat menerima mahasiswa kami melaksanakan Magang / Praktik Kerja Lapangan (PKL) di perusahaan yang Bapak/Ibu pimpin.
        </p>
        
        <p style="text-align: justify;">
            Adapun kegiatan magang tersebut direncanakan pada periode <strong>{{ $application->start_date ? $application->start_date->translatedFormat('d F Y') : '-' }} s/d {{ $application->end_date ? $application->end_date->translatedFormat('d F Y') : '-' }}</strong>. Berikut adalah data mahasiswa yang kami ajukan:
        </p>

        <table class="student-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $application->user->name }}</td>
                    <td>{{ $application->user->nim }}</td>
                    <td>{{ $application->user->department ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <p style="text-indent: 30px; text-align: justify;">
            Demikian surat permohonan ini kami sampaikan. Kami sangat berharap Bapak/Ibu berkenan membantu mahasiswa kami. Atas perhatian dan kerja sama yang baik, kami mengucapkan terima kasih.
        </p>

        <div class="signature">
            <p style="margin-bottom: 0;">Mengetahui,</p>
            <p style="margin-top: 0; font-weight: bold;">Dekan Fakultas</p>
            <div class="signature-space"></div>
            <p style="margin-bottom: 0; text-decoration: underline; font-weight: bold;">Prof. Dr. SiMagang, M.Kom.</p>
            <p style="margin-top: 0;">NIP. 19800101 200501 1 001</p>
        </div>
        
        <div style="clear: both;"></div>
    </div>

</body>
</html>
