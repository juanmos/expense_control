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

class ProcesarFacturaNotification extends Notification
{
    use Queueable;
    private $factura;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($factura)
    {
        $this->factura=$factura;
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
            ->setTitle('Factura '.$this->factura->estado->estado)
            ->setBody('La factura '.$this->factura->factura_numero.' ha sido '.$this->factura->estado->estado);
            
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setPriority(FcmMessage::PRIORITY_HIGH)
            ->setTimeToLive(86400)
            ->setNotification($fcmNotification)
            ->setData(["factura"=>$this->factura->id,"tipo"=>"factura"]);
        ;
    }

    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Factura '.$this->factura->estado->estado)
            ->body('La factura '.$this->factura->factura_numero.' ha sido '.$this->factura->estado->estado)
            ->custom("factura", $this->factura->id)
            ->custom("tipo", 'factura');
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
                    ->subject('Factura '.$this->factura->estado->estado)
                    ->line('La factura '.$this->factura->factura_numero.' ha sido '.$this->factura->estado->estado)
                    ->action('Ver la factura', route('naturales.facturas.show', [$this->factura->institucion_id,$this->factura->id]))
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
