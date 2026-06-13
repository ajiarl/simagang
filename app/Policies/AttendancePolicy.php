<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    public function view(User $user, Attendance $attendance): bool
    {
        if ($user->hasRole('admin')) return true;
        if ($user->hasRole('mahasiswa'))
            return $attendance->internshipApplication->user_id === $user->id;
        if ($user->hasRole('perusahaan'))
            return $attendance->internshipApplication->company_id === $user->company_id;
        return false;
    }

    public function generate(User $user, Attendance $attendance): bool
    {
        return $user->hasRole('mahasiswa')
            && $attendance->internshipApplication->user_id === $user->id;
    }
}
