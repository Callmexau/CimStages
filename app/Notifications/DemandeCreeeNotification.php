<?php

namespace App\Notifications;

use App\Models\DemandeStage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeCreeeNotification extends Notification
{
    use Queueable;

    public function __construct(
        public DemandeStage $demande,
        public string $destinataireType = 'stagiaire'
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Nouvelle demande de stage')
            ->greeting('Bonjour,');

        if ($this->destinataireType === 'stagiaire') {
            $message
                ->line('Votre demande de stage a bien été enregistrée.')
                ->line('Filière : ' . $this->demande->filiere)
                ->line('Université : ' . $this->demande->universite)
                ->line('Type de stage : ' . $this->demande->type_stage);
        } else {
            $message
                ->line('Une nouvelle demande de stage a été soumise sur la plateforme.')
                ->line('Stagiaire : ' . optional($this->demande->stagiaire)->prenom . ' ' . optional($this->demande->stagiaire)->nom)
                ->line('Filière : ' . $this->demande->filiere)
                ->line('Université : ' . $this->demande->universite)
                ->line('Type de stage : ' . $this->demande->type_stage);
        }

        return $message
            ->action('Accéder à la plateforme', url('/login'))
            ->line('CIMBURKINA E-Stage');
    }
}