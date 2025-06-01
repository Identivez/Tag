<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource (admin view).
     */
    public function index()
    {
        $favorites = Favorite::with(['user','product'])->get();
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Display the current user's favorite products.
     */
    public function userFavorites()
    {
        $favorites = Favorite::where('UserId', Auth::id())
            ->with('product')
            ->orderBy('AddedAt', 'desc')
            ->get();

        return view('favorites.user-favorites', compact('favorites'));
    }

    /**
     * Toggle a product as favorite for the current user.
     *
     * This method adds a product to favorites if it's not already there,
     * or removes it if it already exists in the user's favorites.
     */
    public function toggleFavorite(Request $request)
    {
        $validated = $request->validate([
            'ProductId' => 'required|exists:products,ProductId',
        ]);

        $existing = Favorite::where('UserId', Auth::id())
            ->where('ProductId', $validated['ProductId'])
            ->first();

        if ($existing) {
            // El producto ya está en favoritos, lo eliminamos
            $existing->delete();
            $message = 'Producto eliminado de tus favoritos.';
            $status = 'removed';
        } else {
            // El producto no está en favoritos, lo añadimos
            Favorite::create([
                'UserId' => Auth::id(),
                'ProductId' => $validated['ProductId'],
                'AddedAt' => now(),
            ]);
            $message = 'Producto añadido a tus favoritos.';
            $status = 'added';
        }

        // Si la solicitud es AJAX, devolvemos una respuesta JSON
        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message
            ]);
        }

        // De lo contrario, redirigimos con un mensaje flash
        return redirect()->back()->with('success', $message);
    }

    /**
     * Check if a product is in the user's favorites.
     *
     * Useful for AJAX requests to determine UI state.
     */
    public function checkFavorite($productId)
    {
        $isFavorite = Favorite::where('UserId', Auth::id())
            ->where('ProductId', $productId)
            ->exists();

        return response()->json([
            'isFavorite' => $isFavorite
        ]);
    }

    /**
     * Remove multiple favorites at once.
     */
    public function bulkRemove(Request $request)
    {
        $validated = $request->validate([
            'favorites' => 'required|array',
            'favorites.*' => 'exists:favorites,FavoriteId',
        ]);

        // Verificar que los favoritos pertenecen al usuario actual
        $count = Favorite::whereIn('FavoriteId', $validated['favorites'])
            ->where('UserId', Auth::id())
            ->delete();

        return redirect()->route('favorites.user')
            ->with('success', "{$count} productos eliminados de tus favoritos.");
    }

    /**
     * Show the form for creating a new resource (admin).
     */
    public function create()
    {
        // Construimos "ID => Nombre completo" para el select
        $users = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        $products = Product::pluck('Name', 'ProductId');

        return view('favorites.create', compact('users','products'));
    }

    /**
     * Store a newly created resource in storage (admin).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'UserId'    => ['required','exists:users,UserId'],
            'ProductId' => [
                'required','exists:products,ProductId',
                Rule::unique('favorites')
                    ->where(fn($q) => $q->where('UserId', $request->UserId))
            ],
            'AddedAt'   => 'nullable|date',
        ]);

        // Establecer fecha de adición si no fue proporcionada
        if (!isset($data['AddedAt'])) {
            $data['AddedAt'] = now();
        }

        Favorite::create($data);

        return redirect()
            ->route('favorites.index')
            ->with('success', 'Favorito creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Favorite $favorite)
    {
        // Cargar relaciones para mostrar detalles completos
        $favorite->load(['user', 'product']);

        return view('favorites.show', compact('favorite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favorite $favorite)
    {
        $users = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        $products = Product::pluck('Name', 'ProductId');

        return view('favorites.edit', compact('favorite','users','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        $data = $request->validate([
            'UserId'    => ['required','exists:users,UserId'],
            'ProductId' => [
                'required','exists:products,ProductId',
                Rule::unique('favorites')
                    ->ignore($favorite->FavoriteId, 'FavoriteId')
                    ->where(fn($q) => $q->where('UserId', $request->UserId))
            ],
            'AddedAt'   => 'nullable|date',
        ]);

        // Establecer fecha de adición si no fue proporcionada
        if (!isset($data['AddedAt'])) {
            $data['AddedAt'] = now();
        }

        $favorite->update($data);

        return redirect()
            ->route('favorites.index')
            ->with('success', 'Favorito actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorite $favorite)
    {
        $favorite->delete();

        return redirect()
            ->route('favorites.index')
            ->with('success', 'Favorito eliminado correctamente.');
    }
}
