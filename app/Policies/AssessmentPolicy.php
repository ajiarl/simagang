<?php

namespace App\Policies;

use App\Models\InternshipApplication;
use App\Models\User;

class AssessmentPolicy
{
    /**
     * Determine if the given user can assess the application as a Dosen.
     */
    public function assessAsDosen(User $user, InternshipApplication $application): bool
    {
        return $user->hasRole('dosen') && $application->dosen_id === $user->id;
    }

    /**
     * Determine if the given user can assess the application as a Perusahaan.
     */
    public function assessAsPerusahaan(User $user, InternshipApplication $application): bool
    {
        return $user->hasRole('perusahaan') && $application->company_id === $user->company_id;
    }
}
