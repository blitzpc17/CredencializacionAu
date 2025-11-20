<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VariableGlobal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class VariableGlobalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = VariableGlobal::query();
            
            // Filtros
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('valor', 'like', "%{$search}%");
                });
            }

            // Ordenamiento
            $sortField = $request->get('sort_field', 'nombre');
            $sortDirection = $request->get('sort_direction', 'asc');
            $query->orderBy($sortField, $sortDirection);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $variables = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $variables->items(),
                'pagination' => [
                    'current_page' => $variables->currentPage(),
                    'last_page' => $variables->lastPage(),
                    'per_page' => $variables->perPage(),
                    'total' => $variables->total(),
                    'from' => $variables->firstItem(),
                    'to' => $variables->lastItem()
                ],
                'message' => 'Variables globales obtenidas correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las variables globales: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:125|unique:variables_globales,nombre',
                'valor' => 'required|string'
            ]);

            $variable = VariableGlobal::create($request->all());

            return response()->json([
                'success' => true,
                'data' => $variable,
                'message' => 'Variable global creada correctamente'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la variable global: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $variable = VariableGlobal::find($id);

            if (!$variable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Variable global no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $variable,
                'message' => 'Variable global obtenida correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la variable global: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $request->validate([
                'nombre' => [
                    'required',
                    'string',
                    'max:125',
                    Rule::unique('variables_globales')->ignore($id)
                ],
                'valor' => 'required|string'
            ]);

            $variable = VariableGlobal::find($id);

            if (!$variable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Variable global no encontrada'
                ], 404);
            }

            $variable->update($request->all());

            return response()->json([
                'success' => true,
                'data' => $variable,
                'message' => 'Variable global actualizada correctamente'
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
                'message' => 'Error al actualizar la variable global: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $variable = VariableGlobal::find($id);

            if (!$variable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Variable global no encontrada'
                ], 404);
            }

            // No permitir eliminar variables del sistema críticas
            $variablesCriticas = [
                'nombre_sistema',
                'registro_abierto',
                'smtp_host',
                'email_from'
            ];

            if (in_array($variable->nombre, $variablesCriticas)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar esta variable del sistema'
                ], 422);
            }

            $variable->delete();

            return response()->json([
                'success' => true,
                'message' => 'Variable global eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la variable global: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener variable por nombre
     */
    public function obtenerPorNombre(string $nombre): JsonResponse
    {
        try {
            $variable = VariableGlobal::porNombre($nombre)->first();

            if (!$variable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Variable global no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $variable,
                'message' => 'Variable global obtenida correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la variable global: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar o crear variable por nombre
     */
    public function actualizarPorNombre(Request $request, string $nombre): JsonResponse
    {
        try {
            $request->validate([
                'valor' => 'required|string'
            ]);

            $variable = VariableGlobal::actualizarPorNombre($nombre, $request->valor);

            return response()->json([
                'success' => true,
                'data' => $variable,
                'message' => 'Variable global actualizada correctamente'
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
                'message' => 'Error al actualizar la variable global: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener configuración del sistema
     */
    public function obtenerConfiguracionSistema(): JsonResponse
    {
        try {
            $configuracion = VariableGlobal::obtenerConfiguracionSistema();

            return response()->json([
                'success' => true,
                'data' => $configuracion,
                'message' => 'Configuración del sistema obtenida correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la configuración del sistema: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener configuración de email
     */
    public function obtenerConfiguracionEmail(): JsonResponse
    {
        try {
            $configuracion = VariableGlobal::obtenerConfiguracionEmail();

            return response()->json([
                'success' => true,
                'data' => $configuracion,
                'message' => 'Configuración de email obtenida correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la configuración de email: ' . $e->getMessage()
            ], 500);
        }
    }
}