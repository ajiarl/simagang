<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get the active approved application (also allow completed for history view)
        $application = InternshipApplication::where('user_id', $user->id)
            ->whereIn('status', ['approved', 'completed'])
            ->latest()
            ->first();

        if (!$application) {
            return view('mahasiswa.attendances.index', ['attendances' => collect(), 'todayAttendance' => null, 'hasApplication' => false]);
        }

        // Get today's attendance
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('internship_application_id', $application->id)
            ->whereDate('date', today())
            ->first();

        // Get past attendances
        $attendances = Attendance::where('user_id', $user->id)
            ->where('internship_application_id', $application->id)
            ->orderBy('date', 'desc')
            ->get();

        $hasApplication = true;

        return view('mahasiswa.attendances.index', compact('attendances', 'todayAttendance', 'hasApplication'));
    }

    public function generateQr(Request $request)
    {
        $user = auth()->user();

        // Ensure student has approved application
        $application = InternshipApplication::where('user_id', $user->id)
            ->where('status', 'approved')
            ->firstOrFail();

        // Ensure we don't generate duplicate QR for today
        $attendance = Attendance::firstOrCreate(
            [
                'user_id' => $user->id,
                'internship_application_id' => $application->id,
                'date' => today(),
            ],
            [
                'qr_token' => Str::uuid()->toString(),
                'status' => 'pending', // Will be updated to verified by Company
            ]
        );

        $this->authorize('generate', $attendance);

        return back()->with('success', 'QR Code berhasil dibuat untuk hari ini. Silakan tunjukkan kepada pembimbing di perusahaan untuk dipindai.');
    }
}
