<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InternshipApplication;
use App\Models\Company;
use App\Models\InternshipPeriod;
use App\Models\Attendance;
use App\Models\Logbook;

class DashboardController extends Controller
{
    public function mahasiswa()
    {
        $user        = auth()->user();
        $application = $user->internshipApplications()
            ->with(['company', 'internshipPeriod'])
            ->active()
            ->latest()
            ->first();

        $stats = [
            'has_application' => false,
            'status'          => null,
            'company'         => null,
            'period'          => null,
            'hari_total'      => 0,
            'hari_berjalan'   => 0,
            'logbook_total'   => 0,
            'logbook_approved'=> 0,
            'logbook_pending' => 0,
            'logbook_hari_ini'=> false,
            'presensi_total'  => 0,
            'presensi_hadir'  => 0,
            'presensi_persen' => 0,
            'nilai_dosen'     => null,
            'nilai_perusahaan'=> null,
            'nilai_akhir'     => null,
        ];

        if ($application) {
            $stats['has_application'] = true;
            $stats['status']          = $application->status;
            $stats['company']         = $application->company;
            $stats['period']          = $application->internshipPeriod;

            // Hitung hari magang
            if ($application->start_date && $application->end_date) {
                $stats['hari_total']    = $application->start_date
                    ->diffInWeekdays($application->end_date);
                $stats['hari_berjalan'] = $application->start_date
                    ->diffInWeekdays(now() < $application->end_date 
                        ? now() : $application->end_date);
            }

            // Logbook stats
            $logbooks = $application->logbooks;
            $stats['logbook_total']    = $logbooks->count();
            $stats['logbook_approved'] = $logbooks->where('status', 'approved')->count();
            $stats['logbook_pending']  = $logbooks->where('status', 'submitted')->count();
            $stats['logbook_hari_ini'] = $logbooks->where('date', today())->isNotEmpty();

            // Presensi stats
            $attendances = $application->attendances;
            $stats['presensi_total']  = $attendances->count();
            $stats['presensi_hadir']  = $attendances->whereNotNull('verified_at')->count();
            $stats['presensi_persen'] = $stats['presensi_total'] > 0
                ? round(($stats['presensi_hadir'] / $stats['presensi_total']) * 100)
                : 0;

            // Nilai
            $assessments               = $application->assessments;
            $stats['nilai_dosen']      = $assessments->where('assessor_type', 'dosen')->first()?->final_score;
            $stats['nilai_perusahaan'] = $assessments->where('assessor_type', 'perusahaan')->first()?->final_score;
            $stats['nilai_akhir']      = $application->combined_score;
        }

        return view('mahasiswa.dashboard', compact('stats', 'application'));
    }

    public function dosen()
    {
        return view('dosen.dashboard');
    }

    public function admin()
    {
        $stats = [
            // Mahasiswa
            'total_mahasiswa'        => User::role('mahasiswa')->count(),
            'mahasiswa_aktif'        => InternshipApplication::where('status', 'approved')->count(),
            'mahasiswa_selesai'      => InternshipApplication::where('status', 'completed')->count(),

            // Pengajuan
            'pengajuan_pending'      => InternshipApplication::where('status', 'submitted')->count(),
            'pengajuan_total'        => InternshipApplication::count(),

            // Perusahaan & Periode
            'total_perusahaan'       => Company::where('is_active', true)->count(),
            'periode_aktif'          => InternshipPeriod::active()->first(),

            // Presensi hari ini
            'presensi_hari_ini'      => Attendance::whereDate('date', today())
                                            ->whereNotNull('verified_at')->count(),

            // Logbook pending review
            'logbook_pending'        => Logbook::where('status', 'submitted')->count(),

            // Recent: 5 pengajuan terbaru
            'recent_applications'    => InternshipApplication::with(['user', 'company'])
                                            ->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function perusahaan()
    {
        return view('perusahaan.dashboard');
    }
}
