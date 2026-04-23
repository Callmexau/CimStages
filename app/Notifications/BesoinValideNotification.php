<?php

namespace App\Notifications;

use App\Models\BesoinStage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BesoinValideNotification extends Notification
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
            ->subject('Votre besoin de stage a été validé')
            ->greeting('Bonjour ' . ($notifiable->prenom ?? $notifiable->name) . ',')
            ->line('Votre besoin de stage a été validé.')
            ->line('Service : ' . $this->besoin->service)
            ->line('Type de demande : ' . $this->besoin->type_demande)
            ->line('Nombre de stagiaires : ' . $this->besoin->nombre_stagiaires)
            ->action('Accéder à la plateforme', url('/login'))
            ->line('CIMBURKINA E-Stage');
    }
}