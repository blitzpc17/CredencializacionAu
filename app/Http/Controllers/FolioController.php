<?php

namespace App\Http\Controllers;

use App\Models\Folio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $folios = Folio::all();
            
            return response()->json([
                'success' => true,
                'data' => $folios,
                'message' => 'Folios obtenidos correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los folios: ' . $e->getMessage()
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
                'proceso' => 'required|string|max:100',
                'auxiliar' => 'required|string|size:2',
                'consecutivo' => 'required|integer|min:0'
            ]);

            // Verificar si ya existe un folio con el mismo proceso y auxiliar
            $folioExistente = Folio::where('proceso', $request->proceso)
                ->where('auxiliar', $request->auxiliar)
                ->first();

            if ($folioExistente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un folio con este proceso y auxiliar'
                ], 422);
            }

            $folio = Folio::create($request->all());

            return response()->json([
                'success' => true,
                'data' => $folio,
                'message' => 'Folio creado correctamente'
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
                'message' => 'Error al crear el folio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $folio = Folio::find($id);

            if (!$folio) {
                return response()->json([
                    'success' => false,
                    'message' => 'Folio no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $folio,
                'message' => 'Folio obtenido correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el folio: ' . $e->getMessage()
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
                'proceso' => 'required|string|max:100',
                'auxiliar' => 'required|string|size:2',
                'consecutivo' => 'required|integer|min:0'
            ]);

            $folio = Folio::find($id);

            if (!$folio) {
                return response()->json([
                    'success' => false,
                    'message' => 'Folio no encontrado'
                ], 404);
            }

            // Verificar si ya existe otro folio con el mismo proceso y auxiliar
            $folioExistente = Folio::where('proceso', $request->proceso)
                ->where('auxiliar', $request->auxiliar)
                ->where('id', '!=', $id)
                ->first();

            if ($folioExistente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe otro folio con este proceso y auxiliar'
                ], 422);
            }

            $folio->update($request->all());

            return response()->json([
                'success' => true,
                'data' => $folio,
                'message' => 'Folio actualizado correctamente'
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
                'message' => 'Error al actualizar el folio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $folio = Folio::find($id);

            if (!$folio) {
                return response()->json([
                    'success' => false,
                    'message' => 'Folio no encontrado'
                ], 404);
            }

            $folio->delete();

            return response()->json([
                'success' => true,
                'message' => 'Folio eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el folio: ' . $e->getMessage()
            ], 500);
        }
    }

    
}