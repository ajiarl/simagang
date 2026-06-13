<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Document;
use App\Models\InternshipApplication;
use App\Models\InternshipPeriod;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InternshipApplicationController extends Controller
{
    // ── MAHASISWA ROUTES ──

    public function indexMahasiswa()
    {
        $applications = auth()->user()->internshipApplications()->with(['company', 'internshipPeriod', 'dosen'])->latest()->get();
        return view('mahasiswa.applications.index', compact('applications'));
    }

    public function create()
    {
        $activePeriods = InternshipPeriod::where('is_active', true)->get();
        $companies = Company::orderBy('name')->get();

        return view('mahasiswa.applications.create', compact('activePeriods', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'internship_period_id' => 'required|exists:internship_periods,id',
            'company_id'           => 'required|exists:companies,id',
            'motivation'           => 'required|string',
            'ktm_file'             => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_permohonan'     => 'required|file|mimes:pdf|max:5120',
        ]);

        $application = InternshipApplication::create([
            'user_id'              => auth()->id(),
            'company_id'           => $request->company_id,
            'internship_period_id' => $request->internship_period_id,
            'motivation'           => $request->motivation,
            'status'               => 'submitted',
        ]);

        // Upload KTM
        if ($request->hasFile('ktm_file')) {
            $ktmPath = $request->file('ktm_file')->store('documents/ktm');
            Document::create([
                'user_id'                   => auth()->id(),
                'internship_application_id' => $application->id,
                'name'                      => 'KTM',
                'type'                      => 'ktm',
                'file_path'                 => $ktmPath,
                'file_extension'            => $request->file('ktm_file')->extension(),
                'status'                    => 'submitted',
            ]);
        }

        // Upload Surat Permohonan
        if ($request->hasFile('surat_permohonan')) {
            $suratPath = $request->file('surat_permohonan')->store('documents/surat_permohonan');
            Document::create([
                'user_id'                   => auth()->id(),
                'internship_application_id' => $application->id,
                'name'                      => 'Surat Permohonan',
                'type'                      => 'surat_permohonan',
                'file_path'                 => $suratPath,
                'file_extension'            => $request->file('surat_permohonan')->extension(),
                'status'                    => 'submitted',
            ]);
        }

        return redirect()->route('mahasiswa.applications.index')->with('success', 'Pengajuan magang berhasil dikirim.');
    }

    // ── ADMIN ROUTES ──

    public function indexAdmin(Request $request)
    {
        $query = InternshipApplication::with(['user', 'company', 'internshipPeriod'])->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(15);
        
        return view('admin.applications.index', compact('applications'));
    }

    public function show(InternshipApplication $application)
    {
        $this->authorize('view', $application);
        $application->load(['user', 'company', 'internshipPeriod', 'documents', 'dosen']);
        $dosens = User::role('dosen')->orderBy('name')->get();
        
        return view('admin.applications.show', compact('application', 'dosens'));
    }

    public function approve(Request $request, InternshipApplication $application)
    {
        $request->validate([
            'dosen_id'   => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $application->update([
            'status'      => 'approved',
            'dosen_id'    => $request->dosen_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'approved_at' => now(),
        ]);

        $application->user->notify(new \App\Notifications\ApplicationStatusChanged($application));

        return redirect()->route('admin.applications.show', $application)->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, InternshipApplication $application)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $application->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        $application->user->notify(new \App\Notifications\ApplicationStatusChanged($application));

        return redirect()->route('admin.applications.show', $application)->with('success', 'Pengajuan telah ditolak.');
    }

    public function generatePdf(InternshipApplication $application)
    {
        if ($application->status !== 'approved') {
            abort(403, 'Hanya pengajuan yang disetujui yang dapat dicetak surat pengantarnya.');
        }

        $application->load(['user', 'company', 'internshipPeriod']);

        $pdf = Pdf::loadView('pdf.surat-pengantar', compact('application'));
        
        // Return for download
        return $pdf->download('Surat_Pengantar_Magang_' . $application->user->nim . '.pdf');
    }
}
