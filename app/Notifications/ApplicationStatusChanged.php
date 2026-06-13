<?php

namespace App\Notifications;

use App\Models\InternshipApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
    use Queueable;

    public $application;

    public function __construct(InternshipApplication $application)
    {
        $this->application = $application;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $statusText = $this->application->status === 'approved' ? 'disetujui' : 'ditolak';
        
        return [
            'title' => 'Status Pengajuan Diperbarui',
            'message' => "Pengajuan magang Anda di {$this->application->company->name} telah {$statusText}.",
            'url' => route('mahasiswa.applications.index'),
            'icon' => $this->application->status === 'approved' ? 'check_circle' : 'cancel',
            'color' => $this->application->status === 'approved' ? '#166534' : '#ba1a1a',
        ];
    }
}
