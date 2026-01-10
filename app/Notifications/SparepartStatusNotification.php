<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SparepartStatusNotification extends Notification
{
    protected $message;
    protected $url;

    public function __construct($message, $url = null)
    {
        $this->message = $message;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notifikasi Sparepart')
            ->line($this->message)
            ->action('Lihat Detail', $this->url);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Sparepart sudah tersedia / diproses',
            'url' => '/tasks'
        ];
    }
}
