<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // ✅ Sin HasApiTokens

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
        return $this->roles()->where('RoleId', $roleId)->exists();
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isManager()
    {
        return $this->hasRole('manager');
    }

    // Otros métodos útiles
    public function getRouteKeyName()
    {
        return 'UserId';
    }

    public function getNameAttribute()
    {
        return "{$this->firstName} {$this->lastName}";
    }

    // Relaciones
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'MunicipalityId', 'MunId');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->UserId)) {
                $model->UserId = (string) Str::uuid();
            }
        });
    }
}
