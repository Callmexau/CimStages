<?php

namespace App\Notifications;

use App\Models\DemandeStage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StageRenouvelleNotification extends Notification
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
        $nom = trim(($notifiable->prenom ?? '') . ' ' . ($notifiable->nom ?? ''));

        return (new MailMessage)
            ->subject('Stage renouvelé')
            ->greeting('Bonjour ' . ($nom ?: ($notifiable->name ?? '')) . ',')
            ->line('Le stage lié à ce dossier a été renouvelé avec succès.')
            ->line('Nouvelle date de fin : ' . optional($this->demande->fin_stage)?->format('d/m/Y'))
            ->action('Accéder à la plateforme', url('/login'))
            ->line('CIMBURKINA E-Stage');
    }
}