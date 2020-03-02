<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class meuResetDeSenha extends Notification
{
    use Queueable;

    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable){
        return (new MailMessage)
            ->subject('REDEFINIÇÃO DE SENHA')
            ->greeting('Olá!')
            ->line('Você está recebendo este e-mail porque recebemos uma requisição de redefinição de senha da sua conta.')
            ->action('REDEFINIR SENHA', route('password.reset', $this->token))
            ->line('Se você não requisitou uma redefinição de senha, nenhuma ação se faz necessária. Pedimos desculpas pelo incoveniente!!')
            ->markdown('vendor.notifications.email');
    }
}
