<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
public function entity()
{
    return $this->belongsTo(\App\Models\Entity::class, 'EntityId', 'EntityId');
}

    // La tabla usa clave primaria EntityId
    protected $primaryKey = 'EntityId';

    // Es auto‐incremental
    public $incrementing = true;

    // Tipo de la PK
    protected $keyType = 'int';

    // Permitir asignación masiva en estos campos
    protected $fillable = [
        'CountryId',
        'Name',
        'Status',
    ];

    // No usamos timestamps created_at / updated_at
    public $timestamps = false;

    /**
     * Para route‐model binding con {entity}
     */
    public function getRouteKeyName()
    {
        return 'EntityId';
    }

    /**
     * Relación: una Entidad pertenece a un País.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'CountryId', 'CountryId');
    }
}
