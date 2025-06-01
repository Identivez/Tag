<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';

    // Clave primaria personalizada
    protected $primaryKey = 'CartId';
    public $incrementing = true;
    protected $keyType = 'int';

    // No usamos created_at/updated_at automáticos
    public $timestamps = false;

    // Campos rellenables
    protected $fillable = [
        'UserId',
        'ProductId',
        'Quantity',
        'Price',
        'Total',
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
