<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserRoleController extends Controller
{
    /**
     * Constructor - Asegurar que el usuario esté autenticado
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Muestra la gestión de roles de usuarios.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->get('search');
            $roleFilter = $request->get('role_filter');
            $perPage = $request->get('per_page', 15);

            // Query base para usuarios con roles
            $query = User::with('roles', 'municipality');

            // Aplicar filtros de búsqueda
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('firstName', 'like', "%{$search}%")
                      ->orWhere('lastName', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Filtrar por rol específico
            if ($roleFilter) {
                $query->whereHas('roles', function ($q) use ($roleFilter) {
                    $q->where('RoleId', $roleFilter);
                });
            }

            $users = $query->orderBy('firstName')
                          ->paginate($perPage)
                          ->withQueryString();

            // Obtener todos los roles disponibles
            $roles = Role::orderBy('Name')->get();

            // Estadísticas rápidas
            $stats = [
                'total_users' => User::count(),
                'users_with_roles' => User::has('roles')->count(),
                'users_without_roles' => User::doesntHave('roles')->count(),
                'roles_count' => Role::count(),
            ];

            return view('admin.user-roles.index', compact(
                'users',
                'roles',
                'stats',
                'search',
                'roleFilter',
                'perPage'
            ));

        } catch (\Exception $e) {
            Log::error('Error en UserRoleController@index: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error al cargar la gestión de roles.');
        }
    }

    /**
     * Muestra el formulario para asignar roles a un usuario.
     */
    public function edit(User $user)
    {
        try {
            // Cargar relaciones necesarias
            $user->load('roles', 'municipality');

            // Obtener todos los roles disponibles
            $allRoles = Role::orderBy('Name')->get();

            // Roles actuales del usuario
            $userRoles = $user->roles->pluck('RoleId')->toArray();

            // Historial de cambios de roles (si tienes tabla de auditoría)
            $roleHistory = $this->getRoleHistory($user->UserId);

            return view('admin.user-roles.edit', compact(
                'user',
                'allRoles',
                'userRoles',
                'roleHistory'
            ));

        } catch (\Exception $e) {
            Log::error('Error en UserRoleController@edit: ' . $e->getMessage());

            return redirect()->route('admin.user-roles.index')
                           ->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    /**
     * Actualiza los roles de un usuario.
     */
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'roles' => 'sometimes|array',
                'roles.*' => 'exists:roles,RoleId'
            ]);

            DB::beginTransaction();

            // Obtener roles actuales antes del cambio
            $oldRoles = $user->roles->pluck('RoleId')->toArray();

            // Nuevos roles seleccionados
            $newRoles = $request->get('roles', []);

            // Sincronizar roles (esto eliminará los roles no incluidos y agregará los nuevos)
            $user->roles()->sync($newRoles);

            // Registrar el cambio en los logs
            $this->logRoleChange($user, $oldRoles, $newRoles, $request);

            DB::commit();

            return redirect()
                ->route('admin.user-roles.index')
                ->with('success', "Roles del usuario {$user->getFullNameAttribute()} actualizados correctamente.");

        } catch (ValidationException $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en UserRoleController@update: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Error al actualizar los roles: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Asigna un rol específico a un usuario (AJAX).
     */
    public function assignRole(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,UserId',
                'role_id' => 'required|exists:roles,RoleId'
            ]);

            $user = User::where('UserId', $request->user_id)->first();
            $role = Role::where('RoleId', $request->role_id)->first();

            if ($user->hasRole($request->role_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El usuario ya tiene este rol asignado.'
                ], 422);
            }

            DB::beginTransaction();

            $user->assignRole($request->role_id);

            // Registrar la acción con verificación de autenticación
            $currentUser = Auth::user();
            $adminEmail = $currentUser ? $currentUser->email : 'Sistema';

            Log::info('Rol asignado', [
                'user_id' => $user->UserId,
                'user_email' => $user->email,
                'role_assigned' => $request->role_id,
                'assigned_by' => $adminEmail,
                'ip_address' => $request->ip()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Rol '{$role->Name}' asignado correctamente a {$user->getFullNameAttribute()}."
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en UserRoleController@assignRole: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al asignar el rol: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remueve un rol específico de un usuario (AJAX).
     */
    public function removeRole(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,UserId',
                'role_id' => 'required|exists:roles,RoleId'
            ]);

            $user = User::where('UserId', $request->user_id)->first();
            $role = Role::where('RoleId', $request->role_id)->first();

            if (!$user->hasRole($request->role_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El usuario no tiene este rol asignado.'
                ], 422);
            }

            // Verificar que no sea el último rol admin
            if ($request->role_id === 'admin') {
                $adminCount = User::whereHas('roles', function($q) {
                    $q->where('RoleId', 'admin');
                })->count();

                if ($adminCount <= 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se puede remover el último administrador del sistema.'
                    ], 422);
                }
            }

            DB::beginTransaction();

            $user->removeRole($request->role_id);

            // Registrar la acción con verificación de autenticación
            $currentUser = Auth::user();
            $adminEmail = $currentUser ? $currentUser->email : 'Sistema';

            Log::info('Rol removido', [
                'user_id' => $user->UserId,
                'user_email' => $user->email,
                'role_removed' => $request->role_id,
                'removed_by' => $adminEmail,
                'ip_address' => $request->ip()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Rol '{$role->Name}' removido correctamente de {$user->getFullNameAttribute()}."
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en UserRoleController@removeRole: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al remover el rol: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene los usuarios con un rol específico.
     */
    public function getUsersByRole($roleId)
    {
        try {
            $role = Role::where('RoleId', $roleId)->firstOrFail();

            $users = User::whereHas('roles', function($q) use ($roleId) {
                        $q->where('RoleId', $roleId);
                    })
                    ->with('municipality', 'roles')
                    ->orderBy('firstName')
                    ->paginate(20);

            return view('admin.user-roles.by-role', compact('role', 'users'));

        } catch (\Exception $e) {
            Log::error('Error en UserRoleController@getUsersByRole: ' . $e->getMessage());

            return redirect()->route('admin.user-roles.index')
                           ->with('error', 'Error al cargar usuarios por rol.');
        }
    }

    /**
     * Vista de estadísticas de roles.
     */
    public function statistics()
    {
        try {
            // Estadísticas de roles con conteo de usuarios
            $roleStats = Role::withCount('users')
                           ->orderBy('users_count', 'desc')
                           ->get();

            // Estadísticas generales
            $totalUsers = User::count();
            $usersWithRoles = User::has('roles')->count();
            $usersWithoutRoles = $totalUsers - $usersWithRoles;

            // Usuarios con múltiples roles
            $usersWithMultipleRoles = User::has('roles', '>', 1)->count();

            // Distribución de roles por mes (últimos 6 meses) - Versión simplificada
            $roleDistribution = DB::table('role_user')
                ->join('users', 'role_user.UserId', '=', 'users.UserId')
                ->join('roles', 'role_user.RoleId', '=', 'roles.RoleId')
                ->select('roles.Name as role_name', DB::raw('COUNT(*) as count'))
                ->where('users.createdAt', '>=', now()->subMonths(6))
                ->groupBy('roles.Name')
                ->get();

            // Actividad reciente de cambios de roles
            $recentActivity = $this->getRecentRoleActivity();

            return view('admin.user-roles.statistics', compact(
                'roleStats',
                'totalUsers',
                'usersWithRoles',
                'usersWithoutRoles',
                'usersWithMultipleRoles',
                'roleDistribution',
                'recentActivity'
            ));

        } catch (\Exception $e) {
            Log::error('Error en UserRoleController@statistics: ' . $e->getMessage());

            return view('admin.user-roles.statistics')
                   ->with('error', 'Error al cargar las estadísticas.');
        }
    }

    /**
     * Asignación masiva de roles (AJAX).
     */
    public function bulkAssignRole(Request $request)
    {
        try {
            $request->validate([
                'user_ids' => 'required|array',
                'user_ids.*' => 'exists:users,UserId',
                'role_id' => 'required|exists:roles,RoleId'
            ]);

            DB::beginTransaction();

            $successCount = 0;
            $skippedCount = 0;

            foreach ($request->user_ids as $userId) {
                $user = User::where('UserId', $userId)->first();

                if (!$user->hasRole($request->role_id)) {
                    $user->assignRole($request->role_id);
                    $successCount++;
                } else {
                    $skippedCount++;
                }
            }

            // Registrar la acción masiva con verificación de autenticación
            $currentUser = Auth::user();
            $adminEmail = $currentUser ? $currentUser->email : 'Sistema';

            Log::info('Asignación masiva de roles', [
                'role_id' => $request->role_id,
                'users_affected' => $successCount,
                'users_skipped' => $skippedCount,
                'assigned_by' => $adminEmail,
                'ip_address' => $request->ip()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Rol asignado a {$successCount} usuarios. {$skippedCount} usuarios ya tenían el rol."
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en UserRoleController@bulkAssignRole: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error en la asignación masiva: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exporta la lista de usuarios y roles en CSV.
     */
    public function exportUserRoles(Request $request)
    {
        try {
            $filename = 'usuarios_roles_' . date('Y-m-d_H-i-s') . '.csv';

            return response()->streamDownload(function () {
                $output = fopen('php://output', 'w');

                // BOM para UTF-8
                fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

                // Encabezados
                fputcsv($output, [
                    'ID Usuario',
                    'Nombre',
                    'Apellido',
                    'Email',
                    'Municipio',
                    'Roles',
                    'Fecha Registro'
                ]);

                // Datos
                User::with('roles', 'municipality')->chunk(100, function ($users) use ($output) {
                    foreach ($users as $user) {
                        fputcsv($output, [
                            $user->UserId,
                            $user->firstName ?? '',
                            $user->lastName ?? '',
                            $user->email,
                            $user->municipality->Name ?? 'N/A',
                            $user->roles->pluck('Name')->implode(', '),
                            $user->createdAt ? $user->createdAt->format('d/m/Y H:i') : 'N/A'
                        ]);
                    }
                });

                fclose($output);
            }, $filename, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);

        } catch (\Exception $e) {
            Log::error('Error al exportar usuarios y roles: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error al exportar los datos.');
        }
    }

    // Métodos privados auxiliares

    /**
     * Obtiene el historial de cambios de roles de un usuario.
     */
    private function getRoleHistory($userId)
    {
        // Si tienes una tabla de auditoría, puedes implementar esto
        // Por ahora retornamos un array vacío
        return [];
    }

    /**
     * Registra los cambios de roles en el log.
     */
    private function logRoleChange($user, $oldRoles, $newRoles, $request)
    {
        $addedRoles = array_diff($newRoles, $oldRoles);
        $removedRoles = array_diff($oldRoles, $newRoles);

        if (!empty($addedRoles) || !empty($removedRoles)) {
            // Verificar autenticación antes de acceder al usuario
            $currentUser = Auth::user();
            $adminEmail = $currentUser ? $currentUser->email : 'Sistema';

            Log::info('Cambio de roles de usuario', [
                'user_id' => $user->UserId,
                'user_email' => $user->email,
                'old_roles' => $oldRoles,
                'new_roles' => $newRoles,
                'added_roles' => $addedRoles,
                'removed_roles' => $removedRoles,
                'changed_by' => $adminEmail,
                'ip_address' => $request->ip(),
                'timestamp' => now()
            ]);
        }
    }

    /**
     * Obtiene la actividad reciente de cambios de roles.
     */
    private function getRecentRoleActivity()
    {
        // Esta función podría leer del log o de una tabla de auditoría
        // Por ahora retornamos un array vacío
        return [];
    }

    /**
     * Verifica si el usuario actual puede realizar la acción.
     */
    private function canPerformAction()
    {
        $user = Auth::user();
        return $user && $user->hasRole('admin');
    }

    /**
     * Obtiene información del usuario actual de forma segura.
     */
    private function getCurrentUserInfo()
    {
        $user = Auth::user();

        if (!$user) {
            return [
                'id' => null,
                'email' => 'Sistema',
                'name' => 'Sistema'
            ];
        }

        return [
            'id' => $user->UserId,
            'email' => $user->email,
            'name' => $user->getFullNameAttribute()
        ];
    }
}
