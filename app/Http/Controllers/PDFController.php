<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class PdfController extends Controller
{
    public function index()
    {
        return view('pdf.index');
    }

    public function reporteProductos($tipo)
    {
        $productos = Product::with('category')->orderBy('Name')->get();
        $date = now();
        $pdf = Pdf::loadView('pdf.reporte_productos', compact('productos', 'date'));
        return $this->retornarPDF($pdf, $tipo);
    }

    public function reporteStockBajo($tipo)
    {
        $productos = Product::lowStock()->get();
        $date = now();
        $pdf = Pdf::loadView('pdf.reporte_stock_bajo', compact('productos', 'date'));
        return $this->retornarPDF($pdf, $tipo);
    }

    public function reporteUsuariosPedidos($tipo)
    {
        $usuarios = User::withCount('orders')->orderByDesc('orders_count')->get();
        $date = now();
        $pdf = Pdf::loadView('pdf.reporte_usuarios_pedidos', compact('usuarios', 'date'));
        return $this->retornarPDF($pdf, $tipo);
    }
    public function reporteProductosPorCategoria($tipo)
{
    $categorias = \App\Models\Category::with('products')->get();
    $date = now();
    $pdf = Pdf::loadView('pdf.reporte_productos_categoria', compact('categorias', 'date'));
    return $this->retornarPDF($pdf, $tipo);
}


    private function retornarPDF($pdf, $tipo)
    {
        return $tipo == 1 ? $pdf->stream('reporte.pdf') : $pdf->download('reporte.pdf');
    }
}
