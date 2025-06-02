<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function products()
{
    return $this->hasMany(\App\Models\Product::class, 'CategoryId', 'CategoryId');
}

    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'categories';

    // Clave primaria personalizada
    protected $primaryKey = 'CategoryId';

    // Auto‐incremental (integer)
    public $incrementing = true;
    protected $keyType = 'int';

    // Timestamps habilitados (created_at, updated_at)
    public $timestamps = true;

    // Campos rellenables
    protected $fillable = ['Name', 'Description'];
}
