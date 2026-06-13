<?php

namespace App\Policies;

use App\Models\Logbook;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LogbookPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Logbook $logbook): bool
    {
        // Hanya bisa diedit oleh pemilik jika statusnya masih draft atau ditolak
        return $user->id === $logbook->user_id 
            && in_array($logbook->status, ['draft', 'rejected']);
    }

    /**
     * Determine whether the user can review the model (Dosen).
     */
    public function review(User $user, Logbook $logbook): bool
    {
        // Hanya bisa di-review oleh dosen pembimbingnya
        if (!$user->hasRole('dosen')) {
            return false;
        }

        $application = $logbook->internshipApplication;
        if (!$application) {
            return false;
        }

        return $application->dosen_id === $user->id;
    }
}
