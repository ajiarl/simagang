<?php

namespace App\Policies;

use App\Models\InternshipApplication;
use App\Models\User;

class InternshipApplicationPolicy
{
    public function view(User $user, InternshipApplication $application): bool
    {
        if ($user->hasRole('admin')) return true;
        if ($user->hasRole('mahasiswa'))
            return $application->user_id === $user->id;
        if ($user->hasRole('dosen'))
            return $application->dosen_id === $user->id;
        return false;
    }

    public function update(User $user, InternshipApplication $application): bool
    {
        return $user->hasRole('mahasiswa')
            && $application->user_id === $user->id
            && in_array($application->status, ['draft', 'submitted']);
    }
}
