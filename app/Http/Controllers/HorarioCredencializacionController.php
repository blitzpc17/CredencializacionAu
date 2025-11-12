<?php

namespace App\Http\Controllers;

use App\Models\HorarioCredencializacion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class HorarioCredencializacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $horarios = HorarioCredencializacion::where('baja', false)->get();
            
            return response()->json([
                'success' => true,
                'data' => $horarios,
                'message' => 'Horarios obtenidos correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los horarios: ' . $e->getMessage()
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
                'fecha' => 'required|string|max:100',
                'lugar' => 'required|string|max:100',
                'horario' => 'required|string|max:15',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'descripcion' => 'nullable|string'
            ]);

            $data = $request->all();
            $data = array_merge($request->all(), ['baja' => 0]);
            
            // Manejar la subida de imagen
            if ($request->hasFile('imagen')) {
                $imagePath = $request->file('imagen')->store('horarios', 'public');
                $data['imagen'] = $imagePath;
            }

            $horario = HorarioCredencializacion::create($data);

            return response()->json([
                'success' => true,
                'data' => $horario,
                'message' => 'Horario creado correctamente'
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
                'message' => 'Error al crear el horario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $horario = HorarioCredencializacion::find($id);

            if (!$horario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Horario no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $horario,
                'message' => 'Horario obtenido correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el horario: ' . $e->getMessage()
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
                'fecha' => 'required|string|max:100',
                'lugar' => 'nullable|string|max:100',
                'horario' => 'nullable|string|max:15',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'descripcion' => 'nullable|string'
            ]);

            $horario = HorarioCredencializacion::find($id);

            if (!$horario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Horario no encontrado'
                ], 404);
            }

            $data = $request->all();
            
            // Manejar la subida de imagen
            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($horario->imagen && Storage::disk('public')->exists($horario->imagen)) {
                    Storage::disk('public')->delete($horario->imagen);
                }
                
                $imagePath = $request->file('imagen')->store('horarios', 'public');
                $data['imagen'] = $imagePath;
            }

            $horario->update($data);

            return response()->json([
                'success' => true,
                'data' => $horario,
                'message' => 'Horario actualizado correctamente'
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
                'message' => 'Error al actualizar el horario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage (baja lógica).
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $horario = HorarioCredencializacion::find($id);

            if (!$horario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Horario no encontrado'
                ], 404);
            }

            // Baja lógica
            $horario->update(['baja' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Horario eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el horario: ' . $e->getMessage()
            ], 500);
        }
    }
}