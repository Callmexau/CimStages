<?php

namespace App\Notifications;

use App\Models\DemandeStage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeRejeteeNotification extends Notification
{
    use Queueable;

    public function __construct(public DemandeStage $demande)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre demande de stage a été rejetée')
            ->greeting('Bonjour ' . ($notifiable->prenom ?? $notifiable->name) . ',')
            ->line('Votre demande de stage n’a pas été retenue.')
            ->action('Accéder à votre espace', url('/login'))
            ->line('CIMBURKINA E-Stage');
    }
}