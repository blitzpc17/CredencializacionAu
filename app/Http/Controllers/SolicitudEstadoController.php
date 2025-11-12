<?php

namespace App\Http\Controllers;

use App\Models\SolicitudEstado;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SolicitudEstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $estados = SolicitudEstado::all();
            
            return response()->json([
                'success' => true,
                'data' => $estados,
                'message' => 'Estados de solicitud obtenidos correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los estados de solicitud: ' . $e->getMessage()
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
                'nombre' => 'required|string|max:100|unique:solicitudes_estados,nombre'
            ]);

            $estado = SolicitudEstado::create($request->all());

            return response()->json([
                'success' => true,
                'data' => $estado,
                'message' => 'Estado de solicitud creado correctamente'
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
                'message' => 'Error al crear el estado de solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $estado = SolicitudEstado::find($id);

            if (!$estado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado de solicitud no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $estado,
                'message' => 'Estado de solicitud obtenido correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el estado de solicitud: ' . $e->getMessage()
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
                'nombre' => 'required|string|max:100|unique:solicitudes_estados,nombre,' . $id
            ]);

            $estado = SolicitudEstado::find($id);

            if (!$estado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado de solicitud no encontrado'
                ], 404);
            }

            $estado->update($request->all());

            return response()->json([
                'success' => true,
                'data' => $estado,
                'message' => 'Estado de solicitud actualizado correctamente'
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
                'message' => 'Error al actualizar el estado de solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $estado = SolicitudEstado::find($id);

            if (!$estado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado de solicitud no encontrado'
                ], 404);
            }

            $estado->delete();

            return response()->json([
                'success' => true,
                'message' => 'Estado de solicitud eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el estado de solicitud: ' . $e->getMessage()
            ], 500);
        }
    }
}