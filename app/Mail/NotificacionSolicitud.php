<?php

namespace App\Mail;

use App\Models\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;
    public $estadoColor;
    public $estadoTexto;
    public $tipoEmail; // 'confirmacion', 'estado', 'completado'

    /**
     * Create a new message instance.
     */
    public function __construct(Solicitud $solicitud, string $tipoEmail = 'estado')
    {
        $this->solicitud = $solicitud;
        $this->estadoColor = $this->getEstadoColor($solicitud->solicitudes_estadosId);
        $this->estadoTexto = $this->getEstadoTexto($solicitud->solicitudes_estadosId);
        $this->tipoEmail = $tipoEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $asuntos = [
            'confirmacion' => 'Confirmación de Recepción - ' . $this->solicitud->folio,
            'estado' => 'Actualización de Estado - ' . $this->solicitud->folio,
            'completado' => 'Proceso Completado - ' . $this->solicitud->folio
        ];

        return new Envelope(
            subject: $asuntos[$this->tipoEmail] ?? 'Estado de tu Solicitud - ' . $this->solicitud->folio,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.estado-solicitud',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Obtener color del estado para el email
     */
    private function getEstadoColor($estadoId): string
    {
        $colores = [
            1 => '#ffc107', // Pendiente - Amarillo
            2 => '#17a2b8', // En proceso - Azul
            3 => '#28a745', // Aprobado - Verde
            4 => '#6c757d', // Completado - Gris
            5 => '#dc3545'  // Rechazado - Rojo
        ];

        return $colores[$estadoId] ?? '#6c757d';
    }

    /**
     * Obtener texto del estado
     */
    private function getEstadoTexto($estadoId): string
    {
        $estados = [
            1 => 'Pendiente',
            2 => 'En proceso',
            3 => 'Aprobado',
            4 => 'Completado',
            5 => 'Rechazado'
        ];

        return $estados[$estadoId] ?? 'Pendiente';
    }
}