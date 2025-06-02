<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class GraficasController extends Controller
{
    public function index()
    {
        return view('graficas.index');
    }

   public function barras()
{
    $productos = Product::select('Name', 'Price')->orderBy('Name')->get();
    return view('graficas.barras', compact('productos'));
}


    public function pie()
    {
        $productos = Product::select('Name', 'Stock')->orderBy('Name')->get();
        return view('graficas.pie', compact('productos'));
    }

public function columnas()
{
    $productos = Product::select('Name', 'Quantity')->orderBy('Name')->get();
    return view('graficas.columnas', compact('productos'));
}


}
