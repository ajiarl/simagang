<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplication;

class VerificationController extends Controller
{
    public function verify($token)
    {
        $application = InternshipApplication::with(['user', 'company', 'internshipPeriod', 'assessments'])
            ->where('verification_token', $token)
            ->where('status', 'completed')
            ->first();

        return view('verification', compact('application'));
    }
}
