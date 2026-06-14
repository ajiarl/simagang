<?php

namespace App\Notifications;

use App\Models\Logbook;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LogbookReviewed extends Notification
{
    use Queueable;

    public $logbook;

    public function __construct(Logbook $logbook)
    {
        $this->logbook = $logbook;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $isApproved = $this->logbook->status === 'approved';

        $mail = (new MailMessage)
            ->subject('Logbook Anda Telah Direview - SiMagang')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Logbook tanggal ' . $this->logbook->date->format('d M Y') 
                . ' telah ' . ($isApproved ? 'disetujui' : 'diminta revisi') 
                . ' oleh Dosen Pembimbing.');

        if (!$isApproved && $this->logbook->supervisor_note) {
            $mail->line('Catatan: ' . $this->logbook->supervisor_note);
        }

        return $mail->action('Lihat Logbook', route('mahasiswa.logbooks.index'));
    }

    public function toDatabase(object $notifiable): array
    {
        $statusText = $this->logbook->status === 'approved' ? 'disetujui' : 'direvisi';
        
        return [
            'title' => 'Logbook Di-review',
            'message' => "Logbook tanggal {$this->logbook->date->format('d M')} telah {$statusText} oleh Dosen Pembimbing.",
            'url' => route('mahasiswa.logbooks.index'),
            'icon' => $this->logbook->status === 'approved' ? 'check_circle' : 'edit_note',
            'color' => $this->logbook->status === 'approved' ? '#166534' : '#ba1a1a',
        ];
    }
}
