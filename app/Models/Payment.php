<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    // Clave primaria personalizada
    protected $primaryKey = 'PaymentId';
    public $incrementing = true;
    protected $keyType = 'int';

    // No usamos created_at/updated_at automáticos
    public $timestamps = false;

    // Cast de la fecha de la transacción
    protected $casts = [
        'TransactionDate' => 'datetime',
    ];

    // Campos rellenables
    protected $fillable = [
        'OrderId',
        'UserId',
        'PaymentMethod',
        'Amount',
        'PaymentStatus',
        'TransactionDate',
        'PaymentProvider',
    ];

    // Relaciones
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'OrderId', 'OrderId');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'UserId', 'UserId');
    }
}
