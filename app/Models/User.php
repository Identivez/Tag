<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'UserId';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = true;
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'UserId',
        'firstName',
        'lastName',
        'email',
        'password',
        'phoneNumber',
        'MunicipalityId',
        'EntityId',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    // Sistema de roles BÁSICO
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'UserId', 'RoleId');
    }

    public function hasRole($roleId)
    {
        try {
            return $this->roles()->where('role_user.RoleId', $roleId)->exists();
        } catch (\Exception $e) {
            // Si hay error de BD, verificar por email como fallback
            return $this->hasRoleByEmail($roleId);
        }
    }

    /**
     * Método de fallback para verificar roles por email
     * Útil cuando la tabla role_user no existe o hay problemas de BD
     */
    private function hasRoleByEmail($roleId)
    {
        if ($roleId === 'admin') {
            return $this->email === 'admin@test.com';
        }

        if ($roleId === 'manager') {
            return in_array($this->email, ['admin@test.com', 'manager@test.com']);
        }

        return false;
    }

    public function assignRole($roleId)
    {
        try {
            if (!$this->hasRole($roleId)) {
                $this->roles()->attach($roleId);
            }
        } catch (\Exception $e) {
            // Si falla, ignorar silenciosamente
        }
        return $this;
    }

    public function removeRole($roleId)
    {
        try {
            $this->roles()->detach($roleId);
        } catch (\Exception $e) {
            // Si falla, ignorar silenciosamente
        }
        return $this;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isManager()
    {
        return $this->hasRole('manager');
    }

    /**
     * Verificar si es usuario normal (ni admin ni manager)
     */
    public function isUser()
    {
        return !$this->isAdmin() && !$this->isManager();
    }

    /**
     * Obtener el rol principal del usuario
     */
    public function getPrimaryRole()
    {
        if ($this->isAdmin()) return 'admin';
        if ($this->isManager()) return 'manager';
        return 'user';
    }

    /**
     * Obtener el nombre del rol en español
     */
    public function getRoleDisplayName()
    {
        switch ($this->getPrimaryRole()) {
            case 'admin':
                return 'Administrador';
            case 'manager':
                return 'Manager';
            default:
                return 'Usuario';
        }
    }

    // Otros métodos útiles
    public function getRouteKeyName()
    {
        return 'UserId';
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->firstName} {$this->lastName}");
    }

    public function getNameAttribute()
    {
        return $this->getFullNameAttribute();
    }

    /**
     * Obtener iniciales del usuario
     */
    public function getInitialsAttribute()
    {
        $firstName = $this->firstName ? substr($this->firstName, 0, 1) : '';
        $lastName = $this->lastName ? substr($this->lastName, 0, 1) : '';
        return strtoupper($firstName . $lastName);
    }

    // Relaciones
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'MunicipalityId', 'MunId');
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'EntityId', 'EntityId');
    }

    // Relaciones de e-commerce
    public function orders()
    {
        return $this->hasMany(Order::class, 'UserId', 'UserId');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'UserId', 'UserId');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'UserId', 'UserId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'UserId', 'UserId');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'UserId', 'UserId');
    }

    // Métodos de utilidad para el e-commerce
    public function getCartTotal()
    {
        try {
            return $this->cartItems()->sum('Total') ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getCartItemsCount()
    {
        try {
            return $this->cartItems()->sum('Quantity') ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getFavoritesCount()
    {
        try {
            return $this->favorites()->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getOrdersCount()
    {
        try {
            return $this->orders()->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->UserId)) {
                $model->UserId = (string) Str::uuid();
            }
        });

        // Asignar rol de usuario por defecto al crear
        static::created(function ($model) {
            try {
                // Solo asignar rol 'user' si no es admin o manager por email
                if (!$model->hasRoleByEmail('admin') && !$model->hasRoleByEmail('manager')) {
                    $model->assignRole('user');
                }
            } catch (\Exception $e) {
                // Si falla, continuar sin rol
            }
        });
    }
}
