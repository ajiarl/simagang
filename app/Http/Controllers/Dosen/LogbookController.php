<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    /**
     * Display a listing of students assigned to the currently authenticated Dosen.
     */
    public function index()
    {
        // Get applications where this dosen is assigned and status is approved
        $applications = InternshipApplication::with(['user', 'company', 'logbooks' => function ($query) {
                // Count pending logbooks
                $query->where('status', 'submitted');
            }])
            ->where('dosen_id', auth()->id())
            ->where('status', 'approved')
            ->get();

        return view('dosen.logbooks.index', compact('applications'));
    }

    /**
     * Show logbooks for a specific student's application
     */
    public function showStudent($application_id)
    {
        $application = InternshipApplication::with(['user', 'company', 'logbooks' => function ($query) {
                $query->orderBy('date', 'desc');
            }])
            ->where('id', $application_id)
            ->where('dosen_id', auth()->id())
            ->firstOrFail();

        return view('dosen.logbooks.show_student', compact('application'));
    }

    /**
     * Review (Approve/Reject) a specific logbook
     */
    public function review(Request $request, Logbook $logbook)
    {
        $this->authorize('review', $logbook);

        $request->validate([
            'action'          => 'required|in:approve,reject',
            'supervisor_note' => 'nullable|string|required_if:action,reject',
        ]);

        $status = $request->action === 'approve' ? 'approved' : 'rejected';

        $logbook->update([
            'status'          => $status,
            'supervisor_note' => $request->supervisor_note,
            'reviewed_by'     => auth()->id(),
            'reviewed_at'     => now(),
        ]);

        $logbook->user->notify(new \App\Notifications\LogbookReviewed($logbook));

        $msg = $status === 'approved' ? 'Logbook disetujui.' : 'Logbook dikembalikan dengan revisi.';
        return back()->with('success', $msg);
    }
}
