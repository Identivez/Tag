<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    // Clave primaria personalizada
    protected $primaryKey = 'MunId';

    // Es auto-incremental
    public $incrementing = true;

    // Tipo de la PK
    protected $keyType = 'int';

    // Campos rellenables
    protected $fillable = [
        'EntityId',
        'Name',
        'Status',
    ];

    // No usamos created_at / updated_at
    public $timestamps = false;

    /**
     * Para route-model binding con {municipality}
     */
    public function getRouteKeyName()
    {
        return 'MunId';
    }

    /**
     * Relación: un Municipio pertenece a una Entidad.
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'EntityId', 'EntityId');
    }
}
