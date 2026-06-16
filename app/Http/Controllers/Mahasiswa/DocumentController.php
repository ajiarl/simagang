<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\InternshipApplication;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function index()
    {
        $application = auth()->user()
            ->internshipApplications()
            ->with(['documents', 'internshipPeriod', 'company'])
            ->whereIn('status', ['approved', 'completed'])
            ->latest()
            ->first();

        return view('mahasiswa.documents.index', compact('application'));
    }

    public function download(Document $document)
    {
        $this->authorize('view', $document->internshipApplication);

        return Storage::download(
            $document->file_path, 
            $document->original_name
        );
    }

    public function downloadSurat(InternshipApplication $application)
    {
        if ($application->user_id !== auth()->id()) abort(403);
        // Allow both 'approved' and 'completed' — magang selesai tetap bisa download surat
        if (!in_array($application->status, ['approved', 'completed'])) abort(403);

        $application->load(['user', 'company', 'internshipPeriod']);
        $pdf = Pdf::loadView('pdf.surat-pengantar', compact('application'));
        return $pdf->download('surat-pengantar-magang.pdf');
    }

    public function downloadSertifikat(InternshipApplication $application)
    {
        if ($application->user_id !== auth()->id()) abort(403);
        if ($application->status !== 'completed') abort(403);

        $application->load([
            'user', 'company', 'internshipPeriod',
            'assessments', 'logbooks', 'attendances'
        ]);

        $nilaiDosen      = $application->assessments
                            ->where('assessor_type', 'dosen')->first()?->final_score;
        $nilaiPerusahaan = $application->assessments
                            ->where('assessor_type', 'perusahaan')->first()?->final_score;
        $nilaiAkhir      = ($nilaiDosen && $nilaiPerusahaan)
                            ? round(($nilaiDosen + $nilaiPerusahaan) / 2, 2)
                            : null;

        $pdf = Pdf::loadView('pdf.sertifikat', compact(
            'application', 'nilaiDosen', 'nilaiPerusahaan', 'nilaiAkhir'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('sertifikat-magang-' . $application->user->nim . '.pdf');
    }
}
