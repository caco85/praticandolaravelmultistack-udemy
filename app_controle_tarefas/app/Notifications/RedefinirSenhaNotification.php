<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class RedefinirSenhaNotification extends Notification
{
    use Queueable;
    public $token; 
    public $email;
    public $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token,$email,$name)
    {
        $this->token = $token;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = 'http://localhost:8000/password/reset/'.$this->token;
        $minutes =  config('auth.passwords.'.config('auth.defaults.passwords').'.expire');
        $greeting= 'Olá '.$this->name;

         return (new MailMessage)
            ->subject('Atualizar senha')
            ->greeting($greeting)
            ->line('Esqueceu a senha? sem problemas vamos resolver!')
            ->action('Clique aqui para resetar a senhar', $url)
            ->line(Lang::get('O link acima expira em: '.$minutes.' minutos' ))
            ->line(Lang::get('Caso você não tenha solicitado o reset de senha, favor desconciderar.'))
            ->salutation('Até breve!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
