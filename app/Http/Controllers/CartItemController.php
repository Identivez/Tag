<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    /**
     * Display a listing of all cart items (admin view).
     */
    public function index()
    {
        $items = CartItem::with(['user','product'])->get();
        return view('cart-items.index', compact('items'));
    }

    /**
     * Display the shopping cart for the authenticated user.
     */
    public function viewCart()
    {
        $cartItems = CartItem::where('UserId', Auth::id())
            ->with('product')
            ->get();

        $total = $cartItems->sum('Total');

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Combina firstName y lastName para el dropdown de usuarios
        $users = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        $products = Product::pluck('Name', 'ProductId');

        return view('cart-items.create', compact('users','products'));
    }

    /**
     * Store a newly created resource in storage (admin).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'UserId'    => 'required|exists:users,UserId',
            'ProductId' => 'required|exists:products,ProductId',
            'Quantity'  => 'required|integer|min:1',
            'Price'     => 'required|numeric|min:0',
            'Total'     => 'nullable|numeric|min:0',
        ]);

        // Calcular el total si no está establecido
        if (!isset($data['Total'])) {
            $data['Total'] = $data['Price'] * $data['Quantity'];
        }

        CartItem::create($data);

        return redirect()
            ->route('cart-items.index')
            ->with('success', 'Ítem de carrito creado correctamente.');
    }

    /**
     * Add a product to the user's cart.
     */
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'ProductId' => 'required|exists:products,ProductId',
            'Quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['ProductId']);

        // Verificar si el producto ya existe en el carrito
        $existingItem = CartItem::where('UserId', Auth::id())
            ->where('ProductId', $validated['ProductId'])
            ->first();

        if ($existingItem) {
            // Actualizar cantidad
            $existingItem->Quantity += $validated['Quantity'];
            $existingItem->Total = $existingItem->Price * $existingItem->Quantity;
            $existingItem->save();
        } else {
            // Añadir nuevo ítem
            CartItem::create([
                'UserId' => Auth::id(),
                'ProductId' => $validated['ProductId'],
                'Quantity' => $validated['Quantity'],
                'Price' => $product->Price,
                'Total' => $product->Price * $validated['Quantity'],
            ]);
        }

        return redirect()->back()->with('success', 'Producto añadido al carrito.');
    }

    /**
     * Update the quantity of an item in the user's cart.
     */
    public function updateQuantity(Request $request, $cartId)
    {
        $validated = $request->validate([
            'Quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('CartId', $cartId)
            ->where('UserId', Auth::id())
            ->firstOrFail();

        $cartItem->Quantity = $validated['Quantity'];
        $cartItem->Total = $cartItem->Price * $cartItem->Quantity;
        $cartItem->save();

        return redirect()->route('cart.view')->with('success', 'Cantidad actualizada.');
    }

    /**
     * Remove an item from the user's cart.
     */
    public function removeFromCart($cartId)
    {
        $cartItem = CartItem::where('CartId', $cartId)
            ->where('UserId', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->route('cart.view')->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        return view('cart-items.show', compact('cartItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        $users = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        $products = Product::pluck('Name', 'ProductId');

        return view('cart-items.edit', compact('cartItem','users','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $data = $request->validate([
            'Quantity'  => 'required|integer|min:1',
            'Price'     => 'required|numeric|min:0',
            'Total'     => 'nullable|numeric|min:0',
        ]);

        // Calcular el total si no está establecido
        if (!isset($data['Total'])) {
            $data['Total'] = $data['Price'] * $data['Quantity'];
        }

        $cartItem->update($data);

        return redirect()
            ->route('cart-items.index')
            ->with('success', 'Ítem de carrito actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()
            ->route('cart-items.index')
            ->with('success', 'Ítem de carrito eliminado correctamente.');
    }

    /**
     * Vaciar el carrito del usuario actual.
     */
    public function clearCart()
    {
        CartItem::where('UserId', Auth::id())->delete();

        return redirect()->route('cart.view')
            ->with('success', 'Tu carrito ha sido vaciado.');
    }
}
