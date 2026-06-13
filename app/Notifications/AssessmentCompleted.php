<?php

namespace App\Notifications;

use App\Models\Assessment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AssessmentCompleted extends Notification
{
    use Queueable;

    public $assessment;

    public function __construct(Assessment $assessment)
    {
        $this->assessment = $assessment;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $assessorRole = ucfirst($this->assessment->assessor_type);
        
        return [
            'title' => 'Penilaian Baru Masuk',
            'message' => "{$assessorRole} telah memberikan nilai magang untuk Anda.",
            'url' => route('mahasiswa.assessments.index'),
            'icon' => 'grade',
            'color' => '#0058be',
        ];
    }
}
