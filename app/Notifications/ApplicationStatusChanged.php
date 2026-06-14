<?php

namespace App\Notifications;

use App\Models\InternshipApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $isApproved = $this->application->status === 'approved';

        $mail = (new MailMessage)
            ->subject('Status Pengajuan Magang Diperbarui - SiMagang')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Pengajuan magang Anda di ' . $this->application->company->name 
                . ' telah ' . ($isApproved ? 'disetujui' : 'ditolak') . '.');

        if (!$isApproved && $this->application->rejection_reason) {
            $mail->line('Alasan: ' . $this->application->rejection_reason);
        }

        return $mail->action('Lihat Detail', route('mahasiswa.applications.index'))
            ->line('Terima kasih telah menggunakan SiMagang.');
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
