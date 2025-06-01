<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    protected $table = 'product_inventories';

    // Clave primaria
    protected $primaryKey = 'InventoryId';
    public $incrementing = true;
    protected $keyType = 'int';

    // No usamos created_at/updated_at automáticos
    public $timestamps = false;

    // Campos rellenables
    protected $fillable = [
        'ProductId',
        'SizeId',
        'Quantity',
        'Price',
        'SKU',
        'Condition',
        'InStock',
        'ReorderLevel',
    ];

    // Relaciones
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'ProductId');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'SizeId', 'SizeId');
    }
}
