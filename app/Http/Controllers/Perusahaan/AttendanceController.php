<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;

        // Get attendances for this company's applications (active and completed for history)
        $attendances = Attendance::with('user', 'verifier')
            ->whereHas('internshipApplication', function ($q) use ($companyId) {
                $q->where('company_id', $companyId)
                  ->whereIn('status', ['approved', 'completed']);
            })
            ->orderBy('date', 'desc')
            ->get();

        return view('perusahaan.attendances.index', compact('attendances'));
    }

    public function scanner()
    {
        return view('perusahaan.attendances.scanner');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string'
        ]);

        $companyId = auth()->user()->company_id;

        // Find attendance logic as requested by user audit
        $attendance = Attendance::where('qr_token', $request->qr_token)
            ->whereDate('date', today()) // expiry check
            ->whereHas('internshipApplication', function ($q) use ($companyId) {
                $q->where('company_id', $companyId) // ensure company matches
                  ->where('status', 'approved');
            })
            ->whereNull('verified_at') // ensure it hasn't been scanned
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Token QR tidak valid, kadaluarsa, atau sudah diverifikasi.');
        }

        // Update verification
        $attendance->update([
            'check_in'    => now(), // Store full timestamp, format in view if needed
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'status'      => 'verified',
        ]);

        return back()->with('success', 'Kehadiran mahasiswa ' . $attendance->user->name . ' berhasil diverifikasi.');
    }
}
