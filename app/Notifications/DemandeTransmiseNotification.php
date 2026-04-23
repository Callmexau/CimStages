<?php

namespace App\Notifications;

use App\Models\DemandeStage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeTransmiseNotification extends Notification
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
        $stagiaireNom = trim(
            (optional($this->demande->stagiaire)->prenom ?? '') . ' ' .
            (optional($this->demande->stagiaire)->nom ?? '')
        );

        return (new MailMessage)
            ->subject('Nouvelle demande de stage transmise')
            ->greeting('Bonjour ' . ($notifiable->prenom ?? $notifiable->name ?? '') . ',')
            ->line('Une demande de stage vous a été transmise pour traitement.')
            ->line('Stagiaire : ' . ($stagiaireNom ?: 'Non renseigné'))
            ->line('Filière : ' . $this->demande->filiere)
            ->line('Université : ' . $this->demande->universite)
            ->line('Type de stage : ' . $this->demande->type_stage)
            ->action('Accéder à la plateforme', url('/login'))
            ->line('CIMBURKINA E-Stage');
    }
}