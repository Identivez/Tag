<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'RoleId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['RoleId', 'Name'];

    // Sin timestamps si no los usas
    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'RoleId';
    }

    // Relación con usuarios
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'RoleId', 'UserId');
    }

    // Métodos de utilidad
    public function isAdmin(): bool
    {
        return $this->RoleId === 'admin';
    }

    public function isManager(): bool
    {
        return $this->RoleId === 'manager';
    }

    public function isUser(): bool
    {
        return $this->RoleId === 'user';
    }

    /**
     * Obtener el color asociado al rol (para badges, etc.)
     */
    public function getColorAttribute(): string
    {
        switch ($this->RoleId) {
            case 'admin':
                return 'danger';
            case 'manager':
                return 'warning';
            case 'user':
                return 'primary';
            default:
                return 'secondary';
        }
    }

    /**
     * Obtener el icono asociado al rol
     */
    public function getIconAttribute(): string
    {
        switch ($this->RoleId) {
            case 'admin':
                return 'fas fa-user-shield';
            case 'manager':
                return 'fas fa-user-tie';
            case 'user':
                return 'fas fa-user';
            default:
                return 'fas fa-user';
        }
    }

    /**
     * Obtener descripción del rol
     */
    public function getDescriptionAttribute(): string
    {
        switch ($this->RoleId) {
            case 'admin':
                return 'Acceso completo al sistema, gestión de usuarios y configuraciones';
            case 'manager':
                return 'Gestión de productos, categorías y ubicaciones';
            case 'user':
                return 'Acceso a funciones básicas de la tienda';
            default:
                return 'Rol personalizado';
        }
    }

    /**
     * Verificar si el rol tiene ciertos permisos
     */
    public function hasPermission(string $permission): bool
    {
        $permissions = $this->getPermissions();
        return in_array($permission, $permissions);
    }

    /**
     * Obtener permisos del rol
     */
    public function getPermissions(): array
    {
        switch ($this->RoleId) {
            case 'admin':
                return [
                    'manage_users',
                    'manage_roles',
                    'manage_products',
                    'manage_categories',
                    'manage_orders',
                    'view_statistics',
                    'manage_system',
                    'access_admin_panel'
                ];
            case 'manager':
                return [
                    'manage_products',
                    'manage_categories',
                    'manage_providers',
                    'manage_locations',
                    'view_orders'
                ];
            case 'user':
                return [
                    'place_orders',
                    'manage_favorites',
                    'manage_cart',
                    'write_reviews'
                ];
            default:
                return [];
        }
    }

    /**
     * Obtener el nivel de prioridad del rol (para jerarquías)
     */
    public function getPriorityLevel(): int
    {
        switch ($this->RoleId) {
            case 'admin':
                return 100;
            case 'manager':
                return 50;
            case 'user':
                return 10;
            default:
                return 1;
        }
    }

    /**
     * Crear roles por defecto del sistema
     */
    public static function createDefaultRoles(): void
    {
        $roles = [
            [
                'RoleId' => 'admin',
                'Name' => 'Administrador'
            ],
            [
                'RoleId' => 'manager',
                'Name' => 'Manager'
            ],
            [
                'RoleId' => 'user',
                'Name' => 'Usuario'
            ],
        ];

        foreach ($roles as $role) {
            try {
                self::firstOrCreate(
                    ['RoleId' => $role['RoleId']],
                    $role
                );
            } catch (\Exception $e) {
                // Si falla, continuar con el siguiente rol
                continue;
            }
        }
    }

    /**
     * Obtener todos los roles con conteo de usuarios
     */
    public static function withUserCount()
    {
        try {
            return self::withCount('users')->orderBy('users_count', 'desc');
        } catch (\Exception $e) {
            return self::orderBy('RoleId');
        }
    }

    /**
     * Obtener roles disponibles para asignación
     */
    public static function getAssignableRoles()
    {
        return self::whereIn('RoleId', ['admin', 'manager', 'user'])
                   ->orderByRaw("FIELD(RoleId, 'admin', 'manager', 'user')")
                   ->get();
    }

    /**
     * Verificar si es un rol del sistema (no eliminable)
     */
    public function isSystemRole(): bool
    {
        return in_array($this->RoleId, ['admin', 'manager', 'user']);
    }

    /**
     * Scope para roles activos
     */
    public function scopeActive($query)
    {
        return $query->whereIn('RoleId', ['admin', 'manager', 'user']);
    }

    /**
     * Scope para roles administrativos
     */
    public function scopeAdministrative($query)
    {
        return $query->whereIn('RoleId', ['admin', 'manager']);
    }

    /**
     * Obtener estadísticas del rol
     */
    public function getStats(): array
    {
        try {
            return [
                'user_count' => $this->users()->count(),
                'active_users' => $this->users()->whereNotNull('email_verified_at')->count(),
                'recent_users' => $this->users()->where('createdAt', '>=', now()->subDays(30))->count(),
            ];
        } catch (\Exception $e) {
            return [
                'user_count' => 0,
                'active_users' => 0,
                'recent_users' => 0,
            ];
        }
    }
}
