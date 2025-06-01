<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';

    // Clave primaria personalizada
    protected $primaryKey = 'FavoriteId';
    public $incrementing = true;
    protected $keyType = 'int';

    // No usamos created_at/updated_at automáticos
    public $timestamps = false;

    // Cast de la fecha
    protected $casts = [
        'AddedAt' => 'datetime',
    ];

    // Campos rellenables
    protected $fillable = [
        'UserId',
        'ProductId',
        'AddedAt',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'UserId', 'UserId');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'ProductId', 'ProductId');
    }
}
