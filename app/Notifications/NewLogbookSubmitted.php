<?php

namespace App\Notifications;

use App\Models\Logbook;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewLogbookSubmitted extends Notification
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
        return (new MailMessage)
            ->subject('Logbook Baru Menunggu Review - SiMagang')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line($this->logbook->internshipApplication->user->name 
                . ' telah mengumpulkan logbook baru untuk direview.')
            ->action('Review Logbook', route('dosen.logbooks.index'))
            ->line('Mohon segera ditinjau.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Logbook Baru',
            'message' => "{$this->logbook->user->name} telah mengumpulkan logbook baru untuk direview.",
            'url' => route('dosen.logbooks.index'),
            'icon' => 'fact_check',
            'color' => '#0058be',
        ];
    }
}
