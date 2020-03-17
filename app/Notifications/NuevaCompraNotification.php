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

class NuevaCompraNotification extends Notification
{
    use Queueable;
    private $compra;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($compra)
    {
        $this->compra=$compra;
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
            ->setTitle('Nueva factura de compra')
            ->setBody('Hemos recibido una nueva factura de compra electrónica.');
            
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setPriority(FcmMessage::PRIORITY_HIGH)
            ->setTimeToLive(86400)
            ->setNotification($fcmNotification)
            ->setData(["tipo"=>"compra"]);
        ;
    }

    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Nueva factura de compra')
            ->body('Hemos recibido una nueva factura de compra electrónica.')
            ->custom("tipo", 'compra');
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
                    ->subject('Nueva factura de compra de '. $this->compra->cliente->cliente->nombre_comercial)
                    ->line('Hemos recibido una nueva factura de compra electrónica.')
                    ->line('Datos de la compra')
                    ->line('Nombre comercial: '. $this->compra->cliente->cliente->nombre_comercial)
                    ->line('Valor: $'.$this->compra->total)
                    ->line('Factura #: '.$this->compra->factura_numero)
                    ->action('Ver compras', route('naturales.compras.index', [$notifiable->institucion_id]))
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
