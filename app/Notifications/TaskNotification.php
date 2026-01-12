<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $message
    ) {}

    public function via($notifiable)
    {
        // database wajib, mail opsional
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notifikasi Sistem Perbaikan Forklift')
            ->greeting('Halo '.$notifiable->name)
            ->line($this->message)
            ->action('Login ke Aplikasi', url('/login'))
            ->line('Silakan login untuk melihat detail notifikasi.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'url'     => '/login'
        ];
    }
}
