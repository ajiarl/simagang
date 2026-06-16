<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use App\Models\Attendance;
use App\Models\InternshipPeriod;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Exports\AssessmentExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $periods  = InternshipPeriod::orderBy('start_date', 'desc')->get();
        $students = User::role('mahasiswa')->orderBy('name')->get();
        return view('admin.reports.index', compact('periods', 'students'));
    }

    public function exportAttendances(Request $request)
    {
        return Excel::download(new AttendanceExport, 'rekap_kehadiran_' . date('Ymd') . '.xlsx');
    }

    public function exportAssessments(Request $request)
    {
        return Excel::download(new AssessmentExport, 'rekap_penilaian_' . date('Ymd') . '.xlsx');
    }

    public function downloadPdf(Request $request, $applicationId = null)
    {
        $application = null;
        if ($applicationId) {
            $application = InternshipApplication::whereIn('status', ['approved', 'completed'])
                ->find($applicationId);
        } elseif ($request->has('user_id')) {
            $application = InternshipApplication::where('user_id', $request->user_id)
                ->whereIn('status', ['approved', 'completed'])
                ->latest()
                ->first();
        }

        if (!$application) {
            return redirect()->back()->with('error', 'Laporan mahasiswa tidak ditemukan atau belum disetujui.');
        }

        // Load relationships
        $application->load(['user', 'company', 'dosen', 'assessments', 'logbooks']);

        // Stats
        $totalPresent = Attendance::where('internship_application_id', $application->id)
            ->where('status', 'present')
            ->count();
            
        $totalAbsent = Attendance::where('internship_application_id', $application->id)
            ->where('status', 'absent')
            ->count();

        $dosenAssessment = $application->assessments->where('assessor_type', 'dosen')->first();
        $perusahaanAssessment = $application->assessments->where('assessor_type', 'perusahaan')->first();

        $dosenScore = $dosenAssessment?->final_score;
        $perusahaanScore = $perusahaanAssessment?->final_score;

        $finalScore = ($dosenScore && $perusahaanScore)
            ? round(($dosenScore + $perusahaanScore) / 2, 2)
            : null;

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'application',
            'totalPresent',
            'totalAbsent',
            'dosenAssessment',
            'perusahaanAssessment',
            'finalScore'
        ));

        return $pdf->download('Laporan_Magang_' . $application->user->nim . '.pdf');
    }
}
