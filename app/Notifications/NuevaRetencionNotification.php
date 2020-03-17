<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\FcmNotification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;

class NuevaRetencionNotification extends Notification
{
    use Queueable;
    private $retencion;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($retencion)
    {
        $this->retencion=$retencion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class, ApnChannel::class, 'mail'];
    }

    public function toFcm($notifiable)
    {
        // The FcmNotification holds the notification parameters
        $fcmNotification = FcmNotification::create()
            ->setTitle('Nueva retención')
            ->setBody('Hemos recibido una nueva retención electrónica.');
            
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setPriority(FcmMessage::PRIORITY_HIGH)
            ->setTimeToLive(86400)
            ->setNotification($fcmNotification)
            ->setData(["tipo"=>"retencion"]);
        ;
    }

    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Nueva retención')
            ->body('Hemos recibido una nueva retención electrónica.')
            ->custom("tipo", 'retencion');
        ;
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
                    ->subject('Nueva retención recibida de '. $this->retencion->cliente->cliente->nombre_comercial)
                    ->line('Hemos recibido una nueva retención electrónica.')
                    ->line('Datos de la compra')
                    ->line('Nombre comercial: '. $this->retencion->cliente->cliente->nombre_comercial)
                    ->line('Comprobante #: '.$this->retencion->comprobante_numero)
                    ->action('Ver retención', route('naturales.retenciones.index', [$notifiable->institucion_id]))
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
