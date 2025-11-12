<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Solicitud extends Model
{
    use HasFactory;//, SoftDeletes;

    protected $table = 'solicitudes';

    protected $fillable = [
        'folio',
        'solicitudes_estadosId',
        'nombres',
        'apellidos',
        'perfil_academico',
        'escuela_procedencia',
        'lugar_residencia',
        'lugar_origen',
        'lugar_viaja_frecuente',
        'terminalesId',
        'veces_semana',
        'dia_semana_viaja',
        'curp',
        'credencial',
        'fotografia',
        'correo',
        'telefono',
        'formaPago',
        'usuarios_confirma_documentacionId',
        'usuarios_cancela_solicitudId',
        'usuarios_modifico_solicitudId'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'baja_at'
    ];

    // Relaciones
    public function estado()
    {
        return $this->belongsTo(SolicitudEstado::class, 'solicitudes_estadosId');
    }

    public function terminal()
    {
        return $this->belongsTo(Terminal::class, 'terminalesId');
    }

    public function usuarioConfirma()
    {
        return $this->belongsTo(User::class, 'usuarios_confirma_documentacionId');
    }

    public function usuarioCancela()
    {
        return $this->belongsTo(User::class, 'usuarios_cancela_solicitudId');
    }

    public function usuarioModifico()
    {
        return $this->belongsTo(User::class, 'usuarios_modifico_solicitudId');
    }

    // Generar folio automático con transacción
    public static function generarFolio()
    {
        return DB::transaction(function () {
            // Bloquear el registro para evitar condiciones de carrera
            $folioRegistro = Folio::where('proceso', 'CREDENCIALIZACION')
                                ->lockForUpdate()
                                ->first();

            if (!$folioRegistro) {
                throw new \Exception('No se encontró el registro de folio para CREDENCIALIZACION');
            }

            // Generar el folio de 13 caracteres
            $consecutivo = str_pad($folioRegistro->consecutivo, 11, '0', STR_PAD_LEFT);
            $folio = $folioRegistro->auxiliar.$consecutivo;

            // Verificar que el folio no exista (doble verificación)
            $folioExistente = Solicitud::where('folio', $folio)->exists();
            if ($folioExistente) {
                throw new \Exception('El folio generado ya existe en el sistema');
            }

            // Incrementar el consecutivo
            $folioRegistro->increment('consecutivo');

            return $folio;
        });
    }

    // Método alternativo con reintentos para manejar posibles deadlocks
    public static function generarFolioConReintento($maxReintentos = 3)
    {
        $reintentos = 0;

        while ($reintentos < $maxReintentos) {
            try {
                return self::generarFolio();
            } catch (\Exception $e) {
                $reintentos++;
                
                if ($reintentos === $maxReintentos) {
                    throw $e;
                }
                
                // Esperar un momento antes de reintentar
                usleep(100000); // 100ms
            }
        }
    }
}