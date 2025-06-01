<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderDetail extends Model
{
    protected $table = 'provider_details';

    // Clave primaria personalizada
    protected $primaryKey = 'ProviderDetailsId';
    public $incrementing = true;
    protected $keyType = 'int';

    // No usamos timestamps automáticos
    public $timestamps = false;

    // Cast de la fecha de suministro
    protected $casts = [
        'SupplyDate' => 'date',
    ];

    // Campos rellenables
    protected $fillable = [
        'ProviderId',
        'ProductId',
        'Price',
        'Quantity',
        'SupplyDate',
    ];

    // Relaciones
    public function provider()
    {
        return $this->belongsTo(\App\Models\Provider::class, 'ProviderId', 'ProviderId');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'ProductId', 'ProductId');
    }
}
