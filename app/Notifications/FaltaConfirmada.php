<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Http\Models\Falta;

class FaltaConfirmada extends Notification implements ShouldQueue
{
    use Queueable;

    private $falta;
    private $situacao;

    public function __construct(Falta $falta, $situacao){
        $this->falta    = $falta;
        $this->situacao = $situacao;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable){
        return (new MailMessage)
                ->subject('CONFIRMAÇÃO DE FALTA')
                ->greeting('Olá, Professor(a): '.$this->falta->professor->usuario->username)
                ->line('Você está recebendo este e-mail pois uma falta foi confirmada para você, pelo Coordenador: '.$this->falta->turma->curso->coordenador->usuario->username.' do Curso: '.$this->falta->turma->curso->nome)
                ->action('VERIFICAR FALTA', route('home'))
                ->line('Se essa falta não pertence a você ou é equivocada entre em contato com o coordenador através do e-mail: ' .$this->falta->turma->curso->coordenador->usuario->email.' para tomar as devidas soluções cabíveis. Pedimos desculpas pelo transtorno!!')
                ->markdown('mail.falta.confirmada',['falta' => $this->falta]);
    }
}