<?php

namespace App\Notifications;

use App\Models\Logbook;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

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
        return ['database'];
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
