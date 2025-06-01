<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    // Tabla (sigue la convención “sizes”)
    protected $table = 'sizes';

    // Clave primaria personalizada
    protected $primaryKey = 'SizeId';

    // Auto‐incremental (integer)
    public $incrementing = true;
    protected $keyType = 'int';

    // Sin timestamps created_at/updated_at
    public $timestamps = false;

    // Campos rellenables
    protected $fillable = [
        'SizeValue',
        'SizeRegion',
        'SizeType',
        'IsActive',
    ];
}
