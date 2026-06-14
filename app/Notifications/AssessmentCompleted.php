<?php

namespace App\Notifications;

use App\Models\Assessment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Penilaian Magang Baru - SiMagang')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line(ucfirst($this->assessment->assessor_type) 
                . ' telah memberikan nilai magang untuk Anda.')
            ->action('Lihat Nilai', route('mahasiswa.assessments.index'));
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
