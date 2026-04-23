<?php

namespace App\Notifications;

use App\Models\BesoinStage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BesoinRejeteNotification extends Notification
{
    use Queueable;

    public function __construct(public BesoinStage $besoin)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre besoin de stage a été rejeté')
            ->greeting('Bonjour ' . ($notifiable->prenom ?? $notifiable->name) . ',')
            ->line('Votre besoin de stage a été rejeté.')
            ->line('Service : ' . $this->besoin->service)
            ->line('Type de demande : ' . $this->besoin->type_demande)
            ->action('Accéder à la plateforme', url('/login'))
            ->line('CIMBURKINA E-Stage');
    }
}