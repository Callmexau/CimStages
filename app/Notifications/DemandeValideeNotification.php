<?php

namespace App\Notifications;

use App\Models\DemandeStage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeValideeNotification extends Notification
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
            ->subject('Votre demande de stage a été validée')
            ->greeting('Bonjour ' . ($notifiable->prenom ?? $notifiable->name) . ',')
            ->line('Votre demande de stage a été validée.')
            ->line('Début du stage : ' . optional($this->demande->debut_stage)?->format('d/m/Y'))
            ->line('Fin du stage : ' . optional($this->demande->fin_stage)?->format('d/m/Y'))
            ->action('Accéder à votre espace', url('/login'))
            ->line('CIMBURKINA E-Stage');
    }
}