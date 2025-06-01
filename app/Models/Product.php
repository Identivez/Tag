<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Tabla (sigue convención)
    protected $table = 'products';

    // Clave primaria personalizada
    protected $primaryKey = 'ProductId';

    // Auto‐incremental (integer)
    public $incrementing = true;
    protected $keyType = 'int';

    // Usar timestamps pero con columnas custom
    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'LastUpdate';

    // Campos rellenables
    protected $fillable = [
        'Name',
        'Brand',
        'Price',
        'Description',
        'Quantity',
        'Stock',
        'ProviderId',
        'CategoryId',
    ];

    // Casteos de atributos
    protected $casts = [
        'CreatedAt' => 'datetime',
        'LastUpdate' => 'datetime',
        'Price' => 'decimal:2',
        'Stock' => 'integer',
        'Quantity' => 'integer',
    ];

    // Relaciones
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'ProviderId', 'ProviderId');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryId', 'CategoryId');
    }

    /**
     * Relación con imágenes del producto
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'ProductId', 'ProductId');
    }

    /**
     * Relación con reseñas del producto
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'ProductId', 'ProductId');
    }

    /**
     * Relación con favoritos
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'ProductId', 'ProductId');
    }

    /**
     * Relación con items del carrito
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'ProductId', 'ProductId');
    }

    /**
     * Relación con detalles de pedidos
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'ProductId', 'ProductId');
    }

    /**
     * Relación con inventario de productos
     */
    public function inventories()
    {
        return $this->hasMany(ProductInventory::class, 'ProductId', 'ProductId');
    }

    /**
     * Relación con detalles de proveedor
     */
    public function providerDetails()
    {
        return $this->hasMany(ProviderDetail::class, 'ProductId', 'ProductId');
    }

    // Accessors y Mutators

    /**
     * Obtener la URL de la primera imagen del producto
     */
    public function getMainImageUrlAttribute()
    {
        $firstImage = $this->images()->first();
        if ($firstImage && $firstImage->ImageFileName) {
            return asset('storage/' . $firstImage->ImageFileName);
        }
        return asset('estilo/assets/img/placeholder-product.jpg');
    }

    /**
     * Verificar si el producto está en stock
     */
    public function getInStockAttribute()
    {
        return $this->Stock > 0;
    }

    /**
     * Verificar si el producto tiene stock bajo
     */
    public function getLowStockAttribute()
    {
        return $this->Stock <= 5 && $this->Stock > 0;
    }

    /**
     * Obtener el promedio de calificaciones
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('Rating') ?? 0;
    }

    /**
     * Obtener el número total de reseñas
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Obtener el precio formateado
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->Price, 2);
    }

    /**
     * Verificar si el producto es favorito del usuario actual
     */
    public function isFavoriteOf($userId)
    {
        if (!$userId) return false;
        return $this->favorites()->where('UserId', $userId)->exists();
    }

    /**
     * Obtener las tallas disponibles para este producto
     */
    public function getAvailableSizesAttribute()
    {
        return $this->inventories()
            ->where('InStock', true)
            ->with('size')
            ->get()
            ->pluck('size')
            ->unique();
    }

    // Scopes

    /**
     * Scope para productos en stock
     */
    public function scopeInStock($query)
    {
        return $query->where('Stock', '>', 0);
    }

    /**
     * Scope para productos con stock bajo
     */
    public function scopeLowStock($query, $threshold = 5)
    {
        return $query->where('Stock', '<=', $threshold)->where('Stock', '>', 0);
    }

    /**
     * Scope para productos sin stock
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('Stock', '<=', 0);
    }

    /**
     * Scope para filtrar por categoría
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('CategoryId', $categoryId);
    }

    /**
     * Scope para filtrar por proveedor
     */
    public function scopeByProvider($query, $providerId)
    {
        return $query->where('ProviderId', $providerId);
    }

    /**
     * Scope para buscar productos por texto
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('Name', 'like', "%{$search}%")
              ->orWhere('Description', 'like', "%{$search}%")
              ->orWhere('Brand', 'like', "%{$search}%");
        });
    }

    /**
     * Scope para filtrar por rango de precio
     */
    public function scopePriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice !== null) {
            $query->where('Price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('Price', '<=', $maxPrice);
        }
        return $query;
    }

    /**
     * Scope para productos más vendidos
     */
    public function scopeBestSellers($query, $limit = 10)
    {
        return $query->withCount('orderDetails')
            ->orderBy('order_details_count', 'desc')
            ->limit($limit);
    }

    /**
     * Scope para productos mejor calificados
     */
    public function scopeTopRated($query, $minRating = 4, $limit = 10)
    {
        return $query->whereHas('reviews', function($q) use ($minRating) {
            $q->selectRaw('AVG(Rating) as avg_rating')
              ->having('avg_rating', '>=', $minRating);
        })->limit($limit);
    }

    /**
     * Scope para productos más recientes
     */
    public function scopeNewest($query, $limit = null)
    {
        $query = $query->orderBy('CreatedAt', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Scope para productos destacados
     */
    public function scopeFeatured($query, $limit = 3)
    {
        return $query->inStock()
            ->orderBy('CreatedAt', 'desc')
            ->limit($limit);
    }

    /**
     * Obtener productos relacionados basados en la categoría
     */
    public function getRelatedProducts($limit = 4)
    {
        return self::where('CategoryId', $this->CategoryId)
            ->where('ProductId', '!=', $this->ProductId)
            ->inStock()
            ->limit($limit)
            ->get();
    }

    /**
     * Verificar disponibilidad de stock
     */
    public function hasStock($quantity = 1)
    {
        return $this->Stock >= $quantity;
    }

    /**
     * Reducir stock del producto
     */
    public function reduceStock($quantity)
    {
        if ($this->hasStock($quantity)) {
            $this->decrement('Stock', $quantity);
            return true;
        }
        return false;
    }

    /**
     * Incrementar stock del producto
     */
    public function increaseStock($quantity)
    {
        $this->increment('Stock', $quantity);
        return true;
    }
}
