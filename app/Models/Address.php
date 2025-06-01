<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    // Clave primaria personalizada
    protected $primaryKey = 'AddressId';

    // Auto‐incremental (integer)
    public $incrementing = true;
    protected $keyType = 'int';

    // Usar timestamps pero con columnas custom
    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    // Campos rellenables
    protected $fillable = [
        'UserId',
        'AddressLine1',
        'AddressLine2',
        'City',
        'State',
        'ZipCode',
        'Country',
        'CountryId',
        'MunicipalityId',
        'AddressType',
        'IsDefault',
        'IsActive',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'UserId', 'UserId');
    }

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'CountryId', 'CountryId');
    }

    public function municipality()
    {
        return $this->belongsTo(\App\Models\Municipality::class, 'MunicipalityId', 'MunId');
    }
}
