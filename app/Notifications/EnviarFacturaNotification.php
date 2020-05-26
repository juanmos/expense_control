<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;
use Config;

class EnviarFacturaNotification extends Notification
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
                    ->subject('Comprobante electronico recibido')
                    // ->from($this->factura->institucion->configuracion->configuraciones['email_facturacion'],$this->factura->institucion->nombre)
                    ->from(Config::get('mail.from.address'), $this->factura->institucion->nombre)
                    ->greeting('Estimad@s '.$this->factura->cliente->nombre_comercial)
                    ->line('Ha recibido una factura electrónica de '.$this->factura->institucion->nombre.' con los siguientes detalles:')
                    ->line('Fecha: '.Carbon::parse($this->factura->fecha)->format('d-m-Y'))
                    ->line('Factura #: '.$this->factura->factura_numero)
                    ->line('Clave de acceso: '.$this->factura->clave)
                    ->line('Atentamente')
                    ->line($this->factura->institucion->nombre)
                    ->attach(storage_path('app/'.$this->factura->pdf, [
                        'as' => $this->factura->factura_numero.'.pdf',
                        'mime' => 'application/pdf',
                    ]))
                    ->attach(storage_path('app/'.$this->factura->xml, [
                        'as' => $this->factura->factura_numero.'.xml',
                        'mime' => 'application/xml',
                    ]));
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
