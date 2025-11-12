<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $perfiles = Perfil::all();
            
            return response()->json([
                'success' => true,
                'data' => $perfiles,
                'message' => 'Perfiles obtenidos correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los perfiles: ' . $e->getMessage()
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
                'nombre' => 'required|string|max:100'
            ]);

            $perfil = Perfil::create($request->all());

            return response()->json([
                'success' => true,
                'data' => $perfil,
                'message' => 'Perfil creado correctamente'
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
                'message' => 'Error al crear el perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $perfil = Perfil::find($id);

            if (!$perfil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perfil no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $perfil,
                'message' => 'Perfil obtenido correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el perfil: ' . $e->getMessage()
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
                'nombre' => 'required|string|max:100'
            ]);

            $perfil = Perfil::find($id);

            if (!$perfil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perfil no encontrado'
                ], 404);
            }

            $perfil->update($request->all());

            return response()->json([
                'success' => true,
                'data' => $perfil,
                'message' => 'Perfil actualizado correctamente'
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
                'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage (baja lógica si existe el campo).
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $perfil = Perfil::find($id);

            if (!$perfil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perfil no encontrado'
                ], 404);
            }

            // Si en el futuro agregas un campo para baja lógica, puedes usar:
            // if (Schema::hasColumn('perfiles', 'activo')) {
            //     $perfil->update(['activo' => false]);
            // } else {
            //     $perfil->delete();
            // }
            
            // Por ahora, como no hay campo de baja, no permitimos eliminar
            return response()->json([
                'success' => false,
                'message' => 'No se permite eliminar perfiles'
            ], 403);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al intentar eliminar el perfil: ' . $e->getMessage()
            ], 500);
        }
    }
}