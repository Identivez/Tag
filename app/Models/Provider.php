<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    // Tabla (sigue convención, opcional)
    protected $table = 'providers';

    // Clave primaria
    protected $primaryKey = 'ProviderId';

    // Auto‐incremental
    public $incrementing = true;
    protected $keyType = 'int';

    // No usamos created_at/updated_at
    public $timestamps = false;

    // Campos rellenables
    protected $fillable = [
        'Name',
        'ContactEmail',
        'ContactPhone',
        'Address',
        'ContactName',
    ];
}
