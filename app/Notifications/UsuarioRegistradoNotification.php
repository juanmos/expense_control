<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UsuarioRegistradoNotification extends Notification
{
    use Queueable;
    private $institucion;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($institucion)
    {
        $this->institucion=$institucion;
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
        
        return (new MailMessage)
                    ->subject('Bienvenido a Factu')
                    ->greeting('Bienvenid@ '.$notifiable->full_name)
                    ->line('Ahora eres parte de Factu y puedes comenzar a usar todos los servicios que te ofrecemos.')
                    ->line('Conoce mas sobre los servicios que tenemos para tí usando el siguiente link.')
                    ->action('Conoce mas sobre factu', url('/'))
                    ->line('Muchas gracias por usar factu!');
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
