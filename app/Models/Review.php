<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    // Clave primaria personalizada
    protected $primaryKey = 'ReviewId';
    public $incrementing = true;
    protected $keyType = 'int';

    // No usamos created_at/updated_at automáticos
    public $timestamps = false;

    // Cast de la fecha de la reseña
    protected $casts = [
        'ReviewDate' => 'datetime',
    ];

    // Campos rellenables
    protected $fillable = [
        'ProductId',
        'UserId',
        'Rating',
        'Comment',
        'ReviewDate',
    ];

    // Relaciones
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'ProductId', 'ProductId');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'UserId', 'UserId');
    }
}
