<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;

        // Get approved/completed applications for this company
        $applications = InternshipApplication::with(['user', 'assessments' => function ($q) {
            $q->where('assessor_type', 'perusahaan');
        }])
            ->where('company_id', $companyId)
            ->active()
            ->get();

        return view('perusahaan.assessments.index', compact('applications'));
    }

    public function store(Request $request, InternshipApplication $application)
    {
        // Authorization
        $this->authorize('assessAsPerusahaan', [Assessment::class, $application]);

        // Validation
        $validated = $request->validate([
            'discipline' => 'required|integer|min:0|max:100',
            'attitude' => 'required|integer|min:0|max:100',
            'skills' => 'required|integer|min:0|max:100',
            'communication' => 'required|integer|min:0|max:100',
            'initiative' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string'
        ]);

        // Check if already assessed
        $exists = Assessment::where('internship_application_id', $application->id)
            ->where('assessor_id', auth()->id())
            ->where('assessor_type', 'perusahaan')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah memberikan penilaian untuk mahasiswa ini.');
        }

        // Calculate final score
        $finalScore = round(
            ($validated['discipline'] + $validated['attitude'] + $validated['skills'] + $validated['communication'] + $validated['initiative']) / 5,
            2
        );

        // Store
        $assessment = Assessment::create([
            'user_id' => $application->user_id,
            'internship_application_id' => $application->id,
            'assessor_id' => auth()->id(),
            'assessor_type' => 'perusahaan',
            'discipline' => $validated['discipline'],
            'attitude' => $validated['attitude'],
            'skills' => $validated['skills'],
            'communication' => $validated['communication'],
            'initiative' => $validated['initiative'],
            'final_score' => $finalScore,
            'notes' => $validated['notes'],
        ]);

        $application->user->notify(new \App\Notifications\AssessmentCompleted($assessment));

        return back()->with('success', 'Penilaian berhasil disimpan.');
    }
}
