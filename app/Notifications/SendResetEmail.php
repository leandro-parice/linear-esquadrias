<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendResetEmail extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Recuperação de senha')
                    ->line('Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta.')
                    ->action('Redefinir senha', route('password.reset', $this->token))
                    ->line('Se você não solicitou uma reinicialização da senha, nenhuma ação adicional será necessária.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
