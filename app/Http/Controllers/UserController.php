<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = User::with('perfil');
            
            // Filtros
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                      ->orWhere('apellidos', 'like', "%{$search}%")
                      ->orWhere('usuario', 'like', "%{$search}%");
                });
            }
            
            if ($request->has('estado') && $request->estado !== '') {
                $query->where('activo', $request->estado);
            }

            // Ordenamiento
            $sortField = $request->get('sort_field', 'created_at');
            $sortDirection = $request->get('sort_direction', 'desc');
            $query->orderBy($sortField, $sortDirection);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $users = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem()
                ],
                'message' => 'Usuarios obtenidos correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los usuarios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de usuarios
     */
    public function estadisticas(): JsonResponse
    {
        try {
            $total = User::count();
            $activos = User::where('activo', true)->count();
            $inactivos = User::where('activo', false)->count();
            $adminCount = User::whereHas('perfil', function($q) {
                $q->where('nombre', 'like', '%admin%');
            })->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'activos' => $activos,
                    'inactivos' => $inactivos,
                    'administradores' => $adminCount
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'usuario' => 'required|string|max:30|unique:usuarios,usuario',
                'password' => 'required|string|min:8|confirmed',
                'perfilesId' => 'required|exists:perfiles,id',
                'activo' => 'boolean'
            ]);

            $userData = $request->all();
            $userData['password'] = bcrypt($request->password);

            $user = User::create($userData);

            return response()->json([
                'success' => true,
                'data' => $user->load('perfil'),
                'message' => 'Usuario creado correctamente'
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
                'message' => 'Error al crear el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $user = User::with('perfil')->find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Usuario obtenido correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el usuario: ' . $e->getMessage()
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
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'usuario' => [
                    'required',
                    'string',
                    'max:30',
                    Rule::unique('usuarios')->ignore($id)
                ],
                'password' => 'nullable|string|min:8|confirmed',
                'perfilesId' => 'required|exists:perfiles,id',
                'activo' => 'boolean'
            ]);

            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            $userData = $request->except('password_confirmation');
            
            // Si no se proporciona nueva contraseña, mantener la actual
            if (empty($userData['password'])) {
                unset($userData['password']);
            } else {
                $userData['password'] = bcrypt($userData['password']);
            }

            $user->update($userData);

            return response()->json([
                'success' => true,
                'data' => $user->load('perfil'),
                'message' => 'Usuario actualizado correctamente'
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
                'message' => 'Error al actualizar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cambiar estado del usuario (activar/desactivar)
     */
    public function toggleStatus(string $id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            // No permitir desactivar el propio usuario
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes cambiar el estado de tu propio usuario'
                ], 422);
            }

            $nuevoEstado = !$user->activo;
            $user->update(['activo' => $nuevoEstado]);

            $accion = $nuevoEstado ? 'activado' : 'desactivado';
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => "Usuario {$accion} correctamente"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

 /*   public function getPerfiles(): JsonResponse
    {
        dd("entro perro");
        try {
            $perfiles = Perfil::where('activo', true)
                            ->orderBy('nombre')
                            ->get(['id', 'nombre']);

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
    }*/
}