<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $application = auth()->user()->internshipApplications()->where('status', 'approved')->first();

        if (!$application) {
            return redirect()->route('mahasiswa.dashboard')
                ->withErrors(['msg' => 'Anda belum memiliki aplikasi magang yang disetujui.']);
        }

        $logbooks = Logbook::where('internship_application_id', $application->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('mahasiswa.logbooks.index', compact('logbooks', 'application'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $application = auth()->user()->internshipApplications()->where('status', 'approved')->first();

        if (!$application) {
            return redirect()->route('mahasiswa.dashboard')
                ->withErrors(['msg' => 'Anda belum memiliki aplikasi magang yang disetujui.']);
        }

        return view('mahasiswa.logbooks.create', compact('application'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $application = auth()->user()->internshipApplications()->where('status', 'approved')->first();

        if (!$application) {
            return redirect()->route('mahasiswa.dashboard')
                ->withErrors(['msg' => 'Akses ditolak.']);
        }

        $request->validate([
            'date' => [
                'required',
                'date',
                'before_or_equal:today',
                Rule::unique('logbooks', 'date')->where('internship_application_id', $application->id)
            ],
            'activity' => 'required|string',
            'learning' => 'nullable|string',
            'action'   => 'required|in:draft,submit',
        ]);

        $status = $request->action === 'submit' ? 'submitted' : 'draft';

        $logbook = Logbook::create([
            'user_id'                   => auth()->id(),
            'internship_application_id' => $application->id,
            'date'                      => $request->date,
            'activity'                  => $request->activity,
            'learning'                  => $request->learning,
            'status'                    => $status,
        ]);

        if ($logbook->status === 'submitted') {
            $application->dosen->notify(new \App\Notifications\NewLogbookSubmitted($logbook));
        }

        $msg = $status === 'submitted' ? 'Logbook berhasil disubmit ke Dosen.' : 'Logbook berhasil disimpan sebagai draft.';
        return redirect()->route('mahasiswa.logbooks.index')->with('success', $msg);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logbook $logbook)
    {
        $this->authorize('update', $logbook);

        return view('mahasiswa.logbooks.edit', compact('logbook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logbook $logbook)
    {
        $this->authorize('update', $logbook);

        $request->validate([
            'date' => [
                'required',
                'date',
                'before_or_equal:today',
                Rule::unique('logbooks', 'date')
                    ->where('internship_application_id', $logbook->internship_application_id)
                    ->ignore($logbook->id)
            ],
            'activity' => 'required|string',
            'learning' => 'nullable|string',
            'action'   => 'required|in:draft,submit',
        ]);

        $status = $request->action === 'submit' ? 'submitted' : 'draft';

        $logbook->update([
            'date'     => $request->date,
            'activity' => $request->activity,
            'learning' => $request->learning,
            'status'   => $status,
        ]);

        if ($logbook->status === 'submitted') {
            $logbook->internshipApplication->dosen->notify(new \App\Notifications\NewLogbookSubmitted($logbook));
        }

        $msg = $status === 'submitted' ? 'Logbook berhasil disubmit ke Dosen.' : 'Logbook berhasil diupdate (Draft).';
        return redirect()->route('mahasiswa.logbooks.index')->with('success', $msg);
    }
}
