<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $primaryKey = 'RoleId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['RoleId', 'Name', 'name', 'guard_name'];

    protected $attributes = [
        'guard_name' => 'web',
    ];

    public function getRouteKeyName()
    {
        return 'RoleId';
    }

    // Mapear campos para compatibilidad
    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? $this->attributes['Name'] ?? null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['Name'] = $value;
    }

    // Métodos de utilidad
    public function isAdmin(): bool
    {
        return $this->RoleId === 'admin';
    }

    public static function createDefaultRoles(): void
    {
        $roles = [
            ['RoleId' => 'admin', 'Name' => 'Administrador', 'name' => 'admin'],
            ['RoleId' => 'user', 'Name' => 'Usuario', 'name' => 'user'],
            ['RoleId' => 'moderator', 'Name' => 'Moderador', 'name' => 'moderator'],
        ];

        foreach ($roles as $role) {
            self::firstOrCreate(
                ['RoleId' => $role['RoleId']],
                array_merge($role, ['guard_name' => 'web'])
            );
        }
    }
}
