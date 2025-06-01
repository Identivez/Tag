<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard del usuario.
     */
    public function index(Request $request)
    {
        // Obtener las últimas órdenes del usuario
        $orders = Order::where('UserId', $request->user()->UserId)
                      ->latest()
                      ->take(5)
                      ->get();

        // Aquí puedes añadir más datos para el dashboard

        return view('dashboard', compact('orders'));
    }
}
