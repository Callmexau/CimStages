<?php

namespace App\Notifications;

use App\Models\BesoinStage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BesoinRenouvellementValideNotification extends Notification
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
            ->subject('Votre besoin de renouvellement a été validé')
            ->greeting('Bonjour ' . ($notifiable->prenom ?? $notifiable->name) . ',')
            ->line('Votre besoin de renouvellement de stage a été validé.')
            ->line('Service : ' . $this->besoin->service)
            ->line('Durée demandée : ' . ($this->besoin->duree ?? 'Non précisée'))
            ->line('Période souhaitée : ' . ($this->besoin->periode ?? 'Non précisée'))
            ->action('Accéder à la plateforme', url('/login'))
            ->line('CIMBURKINA E-Stage');
    }
}