<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    // Clave primaria personalizada
    protected $primaryKey = 'ImageId';
    public $incrementing = true;
    protected $keyType = 'int';

    // No usamos created_at/updated_at automáticos
    public $timestamps = false;

    // Campos rellenables
    protected $fillable = [
        'ProductId',
        'ImageFileName',
    ];

    // Relaciones
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'ProductId', 'ProductId');
    }
}
