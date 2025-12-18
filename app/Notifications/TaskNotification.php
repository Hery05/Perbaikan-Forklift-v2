<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $message,
        public string $url
    ) {}

    public function via($notifiable)
    {
        return ['database', 'mail']; // PENTING
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notifikasi Sistem Perbaikan Forklift')
            ->greeting('Halo '.$notifiable->name)
            ->line($this->message)
            ->action('Buka Aplikasi', url($this->url))
            ->line('Terima kasih.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'url'     => $this->url
        ];
    }
}
