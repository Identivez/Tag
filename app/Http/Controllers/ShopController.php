<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    /**
     * Mostrar la página principal/home
     */
    public function index(Request $request)
    {
        // Si estamos en la ruta principal (/), mostrar la página de inicio
        if ($request->is('/')) {
            return view('home');
        }

        // Para la tienda, obtener productos filtrados
        $query = Product::with(['category', 'provider']);

        // Filtro por categoría
        if ($request->filled('CategoryId')) {
            $query->where('CategoryId', $request->CategoryId);
        }

        // Filtro por búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Name', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%")
                  ->orWhere('Brand', 'like', "%{$search}%");
            });
        }

        // Filtro por rango de precio
        if ($request->filled('min_price')) {
            $query->where('Price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('Price', '<=', $request->max_price);
        }

        // Ordenamiento
        switch ($request->get('sort', 'newest')) {
            case 'price_low':
                $query->orderBy('Price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('Price', 'desc');
                break;
            case 'name':
                $query->orderBy('Name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('CreatedAt', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('Name')->get();

        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Mostrar detalles de un producto específico
     */
    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }

    /**
     * Mostrar productos filtrados por categoría
     */
    public function byCategory(Category $category)
    {
        $products = Product::where('CategoryId', $category->CategoryId)
            ->paginate(12);
        $categories = Category::pluck('Name', 'CategoryId');

        return view('shop.index', compact('products', 'categories', 'category'));
    }

    /**
     * Búsqueda de productos
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('Name', 'like', "%{$query}%")
            ->orWhere('Description', 'like', "%{$query}%")
            ->paginate(12)
            ->withQueryString();

        $categories = Category::pluck('Name', 'CategoryId');

        return view('shop.index', compact('products', 'categories', 'query'));
    }
}
