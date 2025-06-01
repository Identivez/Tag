<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    // Clave primaria personalizada
    protected $primaryKey = 'OrderId';
    public $incrementing = true;
    protected $keyType = 'int';

    // Habilitar timestamps en columnas custom
    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    // Campos rellenables
    protected $fillable = [
        'UserId',
        'OrderDate',
        'TotalAmount',
        'OrderStatus',
        'PaymentId',
        'ShippingMethod',
        'ShippingCost',
        'ShippingAddressId',
        'BillingAddressId',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'UserId', 'UserId');
    }

    public function payment()
    {
        return $this->belongsTo(\App\Models\Payment::class, 'PaymentId', 'PaymentId');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(\App\Models\Address::class, 'ShippingAddressId', 'AddressId');
    }

    public function billingAddress()
    {
        return $this->belongsTo(\App\Models\Address::class, 'BillingAddressId', 'AddressId');
    }
}
