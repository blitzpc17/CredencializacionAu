<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TerminalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $terminales = Terminal::where('baja', false)->get();
            
            return response()->json([
                'success' => true,
                'data' => $terminales,
                'message' => 'Terminales obtenidos correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los terminales: ' . $e->getMessage()
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
                'nombre' => 'required|string|max:100|unique:terminales,nombre'
            ]);

            $data = $request->all();
            $data = array_merge($request->all(), ['baja' => 0]);
            $terminal = Terminal::create($data);
            

            return response()->json([
                'success' => true,
                'data' => $terminal,
                'message' => 'Terminal creado correctamente'
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
                'message' => 'Error al crear el terminal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $terminal = Terminal::find($id);

            if (!$terminal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terminal no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $terminal,
                'message' => 'Terminal obtenido correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el terminal: ' . $e->getMessage()
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
                'nombre' => 'required|string|max:100|unique:terminales,nombre,' . $id
            ]);

            $terminal = Terminal::find($id);

            if (!$terminal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terminal no encontrado'
                ], 404);
            }

            $terminal->update($request->all());

            return response()->json([
                'success' => true,
                'data' => $terminal,
                'message' => 'Terminal actualizado correctamente'
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
                'message' => 'Error al actualizar el terminal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage (baja lógica).
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $terminal = Terminal::find($id);

            if (!$terminal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terminal no encontrado'
                ], 404);
            }

            // Baja lógica
            $terminal->update(['baja' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Terminal eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el terminal: ' . $e->getMessage()
            ], 500);
        }
    }
}