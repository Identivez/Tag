<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    // No usamos incrementing ni timestamps
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'int';

    // Campos rellenables
    protected $fillable = [
        'OrderId',
        'ProductId',
        'Quantity',
        'UnitPrice',
        'CouponId',
    ];

    // Para route-model binding con clave compuesta
    protected $appends = ['composite_key'];

    public function getCompositeKeyAttribute()
    {
        return "{$this->OrderId}:{$this->ProductId}";
    }

    public function getRouteKeyName()
    {
        return 'composite_key';
    }

    // Relaciones
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'OrderId', 'OrderId');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'ProductId', 'ProductId');
    }
}
