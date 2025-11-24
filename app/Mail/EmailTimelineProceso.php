<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTimelineProceso extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;
    public $estadoId;
    public $motivoCancelacion;

    public function __construct($solicitud, $estadoId, $motivoCancelacion = null)
    {
        $this->solicitud = $solicitud;
        $this->estadoId = $estadoId;
        $this->motivoCancelacion = $motivoCancelacion;
    }

    public function build()
    {
        return $this->subject($this->getSubject())
                    ->view('emails.timeline-proceso')
                    ->with([
                        'solicitud' => $this->solicitud,
                        'estadoId' => $this->estadoId,
                        'motivoCancelacion' => $this->motivoCancelacion,
                        'timelineData' => $this->getTimelineData()
                    ]);
    }

    private function getSubject()
    {
        $subjects = [
            1 => 'Confirmación de Recepción de Solicitud - ' . $this->solicitud->folio,
            5 => 'Confirmación de Pago Recibido - ' . $this->solicitud->folio,
            9 => 'Credencial Lista para Entrega - ' . $this->solicitud->folio,
            7 => 'Proceso Finalizado - ' . $this->solicitud->folio,
            8 => 'Solicitud Cancelada - ' . $this->solicitud->folio
        ];

        return $subjects[$this->estadoId] ?? 'Actualización de Solicitud - ' . $this->solicitud->folio;
    }

    private function getTimelineData()
    {
        return [
            1 => [
                'titulo' => '📋 Solicitud Recibida',
                'mensaje' => 'Hemos recibido tu solicitud de credencialización exitosamente.',
                'instrucciones' => 'Tu folio de seguimiento es: <strong>' . $this->solicitud->folio . '</strong>. Para continuar con el proceso, realiza el pago correspondiente y envía tu comprobante a través de nuestro sistema.',
                'imagen' => 'https://cdn-icons-png.flaticon.com/512/3062/3062634.png',
                'paso_actual' => true,
                'completado' => true
            ],
            5 => [
                'titulo' => '💳 Pago Confirmado',
                'mensaje' => '¡Excelente! Hemos confirmado tu pago correctamente.',
                'instrucciones' => 'Tu documentación está siendo procesada. Te enviaremos una notificación cuando tu credencial esté lista para ser entregada. Mantente atento a tu correo electrónico.',
                'imagen' => 'https://cdn-icons-png.flaticon.com/512/2721/2721289.png',
                'paso_actual' => $this->estadoId == 2,
                'completado' => $this->estadoId >= 2
            ],
            9 => [
                'titulo' => '🖨️ Credencial Impresa',
                'mensaje' => '¡Buenas noticias! Tu credencial está lista para ser entregada.',
                'instrucciones' => 'Puedes recoger tu credencial en la Terminal ' . ($this->solicitud->terminal->nombre ?? 'asignada') . ' en el horario de atención: Lunes a Viernes de 8:00 AM a 6:00 PM. No olvides llevar una identificación oficial.',
                'imagen' => 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png',
                'paso_actual' => $this->estadoId == 3,
                'completado' => $this->estadoId >= 3
            ],
            7 => [
                'titulo' => '✅ Proceso Finalizado',
                'mensaje' => '¡Felicidades! Hemos entregado tu credencial exitosamente.',
                'instrucciones' => 'Tu proceso de credencialización ha sido completado. Gracias por confiar en nuestros servicios. ¡Disfruta de los beneficios de tu credencial!',
                'imagen' => 'https://cdn-icons-png.flaticon.com/512/190/190411.png',
                'paso_actual' => $this->estadoId == 4,
                'completado' => $this->estadoId >= 4
            ],
            8 => [
                'titulo' => '❌ Solicitud Cancelada',
                'mensaje' => 'Lamentamos informarte que tu solicitud ha sido cancelada.',
                'instrucciones' => $this->motivoCancelacion ? 'Motivo: ' . $this->motivoCancelacion : 'Para más información, contacta a nuestro equipo de soporte.',
                'imagen' => 'https://cdn-icons-png.flaticon.com/512/1828/1828843.png',
                'paso_actual' => true,
                'completado' => false
            ]
        ];
    }
}