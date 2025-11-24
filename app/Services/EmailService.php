<?php

namespace App\Services;

use App\Mail\NotificacionSolicitud;
use App\Mail\EmailTimelineProceso;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Enviar email con el estado de la solicitud
     */
    public function enviarEstadoSolicitud(Solicitud $solicitud): bool
    {
        try {
            // Cargar relaciones necesarias
            $solicitud->load(['estado', 'terminal']);
            
            // Enviar email
            Mail::to($solicitud->correo)->send(new EstadoSolicitudMail($solicitud));
            
            Log::info("Email de estado enviado exitosamente", [
                'folio' => $solicitud->folio,
                'email' => $solicitud->correo,
                'estado' => $solicitud->solicitudes_estadosId
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Error al enviar email de estado", [
                'folio' => $solicitud->folio,
                'email' => $solicitud->correo,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Enviar email de confirmación de recepción (cuando se crea la solicitud)
     */
    public function enviarConfirmacionRecepcion(Solicitud $solicitud): bool
    {
        try {
            $solicitud->load(['estado', 'terminal']);
            
            // Podrías crear un Mailable específico para confirmación
            Mail::to($solicitud->correo)->send(new NotificacionSolicitud($solicitud));
            
            Log::info("Email de confirmación enviado exitosamente", [
                'folio' => $solicitud->folio,
                'email' => $solicitud->correo
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Error al enviar email de confirmación", [
                'folio' => $solicitud->folio,
                'email' => $solicitud->correo,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Enviar email notificando cambio de estado
     */
    public function enviarNotificacionCambioEstado(Solicitud $solicitud, string $estadoAnterior): bool
    {
        try {
            $solicitud->load(['estado', 'terminal']);
            
            Mail::to($solicitud->correo)->send(new EstadoSolicitudMail($solicitud));
            
            Log::info("Email de cambio de estado enviado", [
                'folio' => $solicitud->folio,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $solicitud->solicitudes_estadosId,
                'email' => $solicitud->correo
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Error al enviar email de cambio de estado", [
                'folio' => $solicitud->folio,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }



public function enviarConfirmacionPago(Solicitud $solicitud)
{
    try {
        Mail::to($solicitud->correo)
            ->send(new EmailTimelineProceso($solicitud, $solicitud->solicitudes_estadosId, $solicitud->motivo_baja));
        
        Log::info("Email de timeline enviado para solicitud {$solicitud->folio}, estado: {$estadoId}");
        return true;
        
    } catch (\Exception $e) {
        Log::error('Error enviando email de timeline: ' . $e->getMessage());
        return false;
    }
        
}






}