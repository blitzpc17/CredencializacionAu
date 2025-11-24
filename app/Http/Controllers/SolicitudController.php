<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use App\Models\SolicitudEstado;
use App\Models\Terminal;
use App\Models\VariableGlobal;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\EmailTimelineProceso;

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
            $emailEnviado = $this->emailService->enviarConfirmacionPago($solicitud);

          

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




   public function index(Request $request): JsonResponse
    {
        try {
            // Query base con relaciones
            $query = Solicitud::with([
                'estado',
                'terminal',
                'usuarioConfirma',
                'usuarioCancela'
            ]);

            // Filtros
            if ($request->has('estado') && $request->estado) {
                $query->where('solicitudes_estadosId', $request->estado);
            }

            if ($request->has('folio') && $request->folio) {
                $query->where('folio', 'like', '%' . $request->folio . '%');
            }

            if ($request->has('solicitante') && $request->solicitante) {
                $query->where(function($q) use ($request) {
                    $q->where('nombres', 'like', '%' . $request->solicitante . '%')
                      ->orWhere('apellidos', 'like', '%' . $request->solicitante . '%');
                });
            }

            // Ordenamiento
            $sortField = $request->get('sort_field', 'created_at');
            $sortDirection = $request->get('sort_direction', 'desc');
            $query->orderBy($sortField, $sortDirection);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $solicitudes = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $solicitudes->items(),
                'pagination' => [
                    'current_page' => $solicitudes->currentPage(),
                    'last_page' => $solicitudes->lastPage(),
                    'per_page' => $solicitudes->perPage(),
                    'total' => $solicitudes->total(),
                    'from' => $solicitudes->firstItem(),
                    'to' => $solicitudes->lastItem(),
                ],
                'message' => 'Solicitudes obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las solicitudes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de solicitudes
     */
    public function estadisticas(): JsonResponse
    {
        try {
            $total = Solicitud::count();
            $pendientes = Solicitud::where('solicitudes_estadosId', 1)->count();
            $proceso = Solicitud::where('solicitudes_estadosId', 2)->count();
            $aprobadas = Solicitud::where('solicitudes_estadosId', 3)->count();
            $completadas = Solicitud::where('solicitudes_estadosId', 4)->count();
            $rechazadas = Solicitud::where('solicitudes_estadosId', 5)->count();

            // Solicitudes por mes (últimos 6 meses)
            $solicitudesPorMes = Solicitud::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'pendientes' => $pendientes,
                    'proceso' => $proceso,
                    'aprobadas' => $aprobadas,
                    'completadas' => $completadas,
                    'rechazadas' => $rechazadas,
                    'solicitudes_por_mes' => $solicitudesPorMes
                ],
                'message' => 'Estadísticas obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }


     public function cambiarEstado(Request $request, string $id): JsonResponse
    {
        try {
            $request->validate([
                'solicitudes_estadosId' => 'required|exists:solicitudes_estados,id',
                'accion' => 'sometimes|string' // confirmar, cancelar, etc.
            ]);

            $solicitud = Solicitud::find($id);

            if (!$solicitud) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solicitud no encontrada'
                ], 404);
            }

            $updateData = ['solicitudes_estadosId' => $request->solicitudes_estadosId];
            
            // Asignar usuario según la acción
            if ($request->accion === 'confirmar') {
                $updateData['usuarios_confirma_documentacionId'] = auth()->id();
            } elseif ($request->accion === 'cancelar') {
                $updateData['usuarios_cancela_solicitudId'] = auth()->id();
            }

            $solicitud->update($updateData);

            $accion = $request->accion ?: 'actualizado';
            return response()->json([
                'success' => true,
                'data' => $solicitud->load('estado'),
                'message' => "Estado de la solicitud {$accion} correctamente"
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }


     public function destroy(string $id): JsonResponse
    {
        try {
            $solicitud = Solicitud::find($id);

            if (!$solicitud) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solicitud no encontrada'
                ], 404);
            }

            $solicitud->update([
                'baja_at' => now(),
                'usuarios_cancela_solicitudId' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Solicitud dada de baja correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al dar de baja la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }


     public function getFormData(): JsonResponse
    {
        try {
            $estados = SolicitudEstado::
                            orderBy('nombre')
                            ->get(['id', 'nombre']);
            
            $terminales = Terminal::orderBy('id')
                            ->get(['id', 'nombre']);


             // Obtener variables globales
        $variables = VariableGlobal::whereIn('nombre', ['dias_semana', 'formas_pago', 'perfiles_academicos'])
                        ->get()
                        ->keyBy('nombre');

        // Función helper para procesar JSON
        $processJsonData = function($variable) {
            if (!$variable) {
                return [];
            }
            
            $data = json_decode($variable->valor, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [];
            }
            
            // Si ya es un array con estructura id/nombre, devolver tal cual
            if (isset($data[0]) && isset($data[0]['id']) && isset($data[0]['nombre'])) {
                return $data;
            }
            
            // Si es un array asociativo, convertirlo a estructura id/nombre
            if (is_array($data)) {
                $result = [];
                foreach ($data as $id => $nombre) {
                    $result[] = ['id' => $id, 'nombre' => $nombre];
                }
                return $result;
            }
            
            return [];
        };

        // Procesar cada variable
        $perfilesAcademicos = $processJsonData($variables['perfiles_academicos'] ?? null);
        $formasPago = $processJsonData($variables['formas_pago'] ?? null);
        $diasSemana = $processJsonData($variables['dias_semana'] ?? null);

        // Valores por defecto si no hay datos
        $perfilesAcademicos = empty($perfilesAcademicos) ? [
            ['id' => 1, 'nombre' => 'Estudiante'],
            ['id' => 2, 'nombre' => 'Maestro']
        ] : $perfilesAcademicos;

        $formasPago = empty($formasPago) ? [
            ['id' => 1, 'nombre' => 'TRANSFERENCIA'],
            ['id' => 2, 'nombre' => 'TAQUILLA']
        ] : $formasPago;

        $diasSemana = empty($diasSemana) ? [
            ['id' => 1, 'nombre' => 'Lunes'],
            ['id' => 2, 'nombre' => 'Martes'],
            ['id' => 3, 'nombre' => 'Miércoles'],
            ['id' => 4, 'nombre' => 'Jueves'],
            ['id' => 5, 'nombre' => 'Viernes'],
            ['id' => 6, 'nombre' => 'Sábado'],
            ['id' => 7, 'nombre' => 'Domingo']
        ] : $diasSemana;

        return response()->json([
            'success' => true,
            'data' => [
                'estados' => $estados,
                'terminales' => $terminales,
                'perfiles_academicos' => $perfilesAcademicos,
                'formas_pago' => $formasPago,
                'dias_semana' => $diasSemana
            ],
            'message' => 'Datos para formulario obtenidos correctamente'
        ]);
          
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos del formulario: ' . $e->getMessage()
            ], 500);
        }
    }


    // En tu SolicitudController, agrega este método:

public function getFile($id, $field)
{
    try {
        $solicitud = Solicitud::findOrFail($id);
        
        // Validar que el campo existe y tiene un archivo
        $validFields = ['curp', 'credencial', 'fotografia', 'voucher_pago'];
        if (!in_array($field, $validFields) || empty($solicitud->$field)) {
            return response()->json([
                'success' => false,
                'message' => 'Archivo no encontrado'
            ], 404);
        }

        $filePath = storage_path('app/public/' . $solicitud->$field);
        
        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Archivo no encontrado en el servidor'
            ], 404);
        }

        // Obtener el tipo MIME correcto
        $mimeType = mime_content_type($filePath);
        
        // Obtener el nombre original del archivo
        $fileName = basename($solicitud->$field);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar el archivo: ' . $e->getMessage()
        ], 500);
    }
}



/**
 * Display the specified resource.
 */
public function show(string $id): JsonResponse
{
    try {
        // Buscar la solicitud por ID con relaciones
        $solicitud = Solicitud::with([
            'estado',
            'terminal',
            'usuarioConfirma',
            'usuarioCancela',
            'usuarioModifico'
        ])->find($id);

        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la solicitud solicitada'
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



public function update(Request $request, string $id)
{
    // Validación de datos para actualización
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
        'curp' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'credencial' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'fotografia' => 'sometimes|file|mimes:jpg,jpeg,png|max:2048',
        'voucher_pago' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'correo' => 'required|email|max:100',
        'telefono' => 'required|string|max:13',
        'formaPago' => 'required|integer',
        'solicitudes_estadosId' => 'sometimes|integer|exists:solicitudes_estados,id',
        'vigencia' => 'nullable|date',
        'id_credencial' => 'nullable|string|max:10'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Errores de validación',
            'errors' => $validator->errors()
        ], 422);
    }

    DB::beginTransaction();

    try {
        $solicitud = Solicitud::find($id);
        
        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'Solicitud no encontrada'
            ], 404);
        }

        // Preparar datos para actualización
        $updateData = [
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
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'formaPago' => $request->formaPago,
            'usuarios_modificoId' => auth()->id(),
            'updated_at' => now(),
        ];

        // DETECTAR SI SE SUBIÓ UN VOUCHER
        $voucherSubido = $request->hasFile('voucher_pago');
        
        // Si se subió un voucher, cambiar automáticamente al estado PAGADO
        if ($voucherSubido) {
            // Buscar el estado PAGADO en la base de datos
            $estadoPagado = SolicitudEstado::where('nombre', 'like', '%PAGAD%')->first();
            
            if ($estadoPagado) {
                $updateData['solicitudes_estadosId'] = $estadoPagado->id;
                
                // También enviar email de confirmación de pago si existe el servicio
                //ver si se deja o se quita el envio de correo aqui
                try {
                    $solicitud->solicitudes_estadosId = $estadoPagado->id;
                    $this->emailService->enviarConfirmacionPago($solicitud);
                } catch (\Exception $e) {
                    // No fallar si el email no se puede enviar, solo loggear
                    \Log::error('Error enviando email de confirmación de pago: ' . $e->getMessage());
                }
            }
        } else {
            // Si no se subió voucher, mantener el estado que viene en el request o el actual
            if ($request->has('solicitudes_estadosId')) {
                $updateData['solicitudes_estadosId'] = $request->solicitudes_estadosId;
            }
        }

        // Campos condicionales para estado PAGADO
        if (isset($updateData['solicitudes_estadosId'])) {
            $estadoActual = SolicitudEstado::find($updateData['solicitudes_estadosId']);
            if ($estadoActual && (strpos($estadoActual->nombre, 'PAGAD') !== false)) {
                if ($request->has('vigencia') && $request->vigencia) {
                    $updateData['vigencia'] = $request->vigencia;
                }
                if ($request->has('id_credencial') && $request->id_credencial) {
                    $updateData['id_credencial'] = $request->id_credencial;
                }
            }
        }

        // Procesar archivos si se enviaron
        $archivosProcesados = [];

        if ($request->hasFile('curp')) {
            if ($solicitud->curp && Storage::disk('public')->exists($solicitud->curp)) {
                Storage::disk('public')->delete($solicitud->curp);
            }
            $curpPath = $request->file('curp')->store('documentos/curp', 'public');
            $updateData['curp'] = $curpPath;
            $archivosProcesados[] = 'curp';
        }

        if ($request->hasFile('credencial')) {
            if ($solicitud->credencial && Storage::disk('public')->exists($solicitud->credencial)) {
                Storage::disk('public')->delete($solicitud->credencial);
            }
            $credencialPath = $request->file('credencial')->store('documentos/credenciales', 'public');
            $updateData['credencial'] = $credencialPath;
            $archivosProcesados[] = 'credencial';
        }

        if ($request->hasFile('fotografia')) {
            if ($solicitud->fotografia && Storage::disk('public')->exists($solicitud->fotografia)) {
                Storage::disk('public')->delete($solicitud->fotografia);
            }
            $fotografiaPath = $request->file('fotografia')->store('documentos/fotografias', 'public');
            $updateData['fotografia'] = $fotografiaPath;
            $archivosProcesados[] = 'fotografia';
        }

        if ($voucherSubido) {
            if ($solicitud->voucher_pago && Storage::disk('public')->exists($solicitud->voucher_pago)) {
                Storage::disk('public')->delete($solicitud->voucher_pago);
            }
            $voucherPath = $request->file('voucher_pago')->store('documentos/vouchers', 'public');
            $updateData['voucher_pago'] = $voucherPath;
            $archivosProcesados[] = 'voucher_pago';
        }

        // Actualizar la solicitud
        $solicitud->update($updateData);

        DB::commit();

        // Cargar relaciones actualizadas
        $solicitud->load(['estado', 'terminal', 'usuarioModifico']);

        $mensaje = 'Solicitud actualizada correctamente';
        if ($voucherSubido) {
            $mensaje .= ' y estado cambiado a PAGADO automáticamente';
        }
        if (count($archivosProcesados) > 0) {
            $mensaje .= ' (archivos actualizados: ' . implode(', ', $archivosProcesados) . ')';
        }

        return response()->json([
            'success' => true,
            'message' => $mensaje,
            'data' => $solicitud,
            'archivos_actualizados' => $archivosProcesados,
            'estado_actualizado' => $voucherSubido
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        // Eliminar archivos subidos en caso de error
        foreach ($archivosProcesados as $archivo) {
            if (isset(${$archivo . 'Path'}) && Storage::disk('public')->exists(${$archivo . 'Path'})) {
                Storage::disk('public')->delete(${$archivo . 'Path'});
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar la solicitud',
            'error' => $e->getMessage()
        ], 500);
    }
}






    




}