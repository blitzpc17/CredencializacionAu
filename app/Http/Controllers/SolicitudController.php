<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class SolicitudController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
    
    public function store(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'perfil_academico' => 'required|integer',
            'escuela_procedencia' => 'required|string|max:125',
            'lugar_residencia' => 'required|string|max:100',
            'lugar_origen' => 'required|string|max:100',
            'lugar_viaja_frecuente' => 'required|string|max:100',
            'terminalesId' => 'required|integer',
            'veces_semana' => 'required|string|max:10',
            'dia_semana_viaja' => 'required|integer',
            'curp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'credencial' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'fotografia' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'correo' => 'required|email|max:100',
            'telefono' => 'required|string|max:13',
            'formaPago' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Iniciar transacción completa
        DB::beginTransaction();

        try {
            // Generar folio dentro de la transacción
            $folio = Solicitud::generarFolioConReintento();

            // Procesar archivos
            $curpPath = $request->file('curp')->store('documentos/curp', 'public');
            $credencialPath = $request->file('credencial')->store('documentos/credenciales', 'public');
            $fotografiaPath = $request->file('fotografia')->store('documentos/fotografias', 'public');

            // Crear solicitud
            $solicitud = Solicitud::create([
                'folio' => $folio,
                'solicitudes_estadosId' => 1, // Estado inicial (pendiente)
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'perfil_academico' => $request->perfil_academico,
                'escuela_procedencia' => $request->escuela_procedencia,
                'lugar_residencia' => $request->lugar_residencia,
                'lugar_origen' => $request->lugar_origen,
                'lugar_viaja_frecuente' => $request->lugar_viaja_frecuente,
                'terminalesId' => $request->terminalesId,
                'veces_semana' => $request->veces_semana,
                'dia_semana_viaja' => $request->dia_semana_viaja,
                'curp' => $curpPath,
                'credencial' => $credencialPath,
                'fotografia' => $fotografiaPath,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'formaPago' => $request->formaPago,
                'created_at' => now(),
            ]);

            // Confirmar transacción
            DB::commit();

             // Enviar email de confirmación (fuera de la transacción)
            $emailEnviado = $this->emailService->enviarConfirmacionRecepcion($solicitud);

          

            return response()->json([
                'success' => true,
                'message' => 'Solicitud registrada exitosamente' . ($emailEnviado ? ' y email enviado' : ''),
                'folio' => $solicitud->folio,
                'email_enviado' => $emailEnviado,
                'data' => $solicitud
            ], 201);

        } catch (\Exception $e) {
            // Revertir transacción
            DB::rollBack();

            // Eliminar archivos subidos en caso de error
            if (isset($curpPath)) Storage::disk('public')->delete($curpPath);
            if (isset($credencialPath)) Storage::disk('public')->delete($credencialPath);
            if (isset($fotografiaPath)) Storage::disk('public')->delete($fotografiaPath);

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la solicitud',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function consultarPorFolio($folio): JsonResponse
    {
        try {
            // Buscar la solicitud por folio con relaciones
            $solicitud = Solicitud::with([
                'estado',
                'terminal'
            ])->where('folio', $folio)->first();

            if (!$solicitud) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró ninguna solicitud con el folio proporcionado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $solicitud,
                'message' => 'Solicitud encontrada correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al consultar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }




}