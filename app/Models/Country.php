<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function country()
{
    return $this->belongsTo(\App\Models\Country::class, 'CountryId', 'CountryId');
}

    // Nombre de la clave primaria
    protected $primaryKey = 'CountryId';

    // PK auto‐incremental
    public $incrementing = true;

    // Tipo de la PK
    protected $keyType = 'int';

    // Campos rellenables
    protected $fillable = ['Name','Key','Status'];

    // Sin timestamps created_at/updated_at
    public $timestamps = false;

    /**
     * Usar CountryId para el route‐model binding
     */
    public function getRouteKeyName()
    {
        return 'CountryId';
    }
}
