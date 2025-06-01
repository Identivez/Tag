<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['product','user'])->get();
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::pluck('Name', 'ProductId');

        // Combinar firstName y lastName
        $users = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        return view('reviews.create', compact('products','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ProductId'  => 'required|exists:products,ProductId',
            'UserId'     => 'required|exists:users,UserId',
            'Rating'     => 'nullable|integer|min:1|max:5',
            'Comment'    => 'nullable|string',
            'ReviewDate' => 'nullable|date',
        ]);

        Review::create($data);

        return redirect()
            ->route('reviews.index')
            ->with('success', 'Reseña creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        $products = Product::pluck('Name', 'ProductId');

        $users = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        return view('reviews.edit', compact('review','products','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'Rating'     => 'nullable|integer|min:1|max:5',
            'Comment'    => 'nullable|string',
            'ReviewDate' => 'nullable|date',
        ]);

        $review->update($data);

        return redirect()
            ->route('reviews.index')
            ->with('success', 'Reseña actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()
            ->route('reviews.index')
            ->with('success', 'Reseña eliminada correctamente.');
    }
}
