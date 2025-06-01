<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\PDF;

class PDFController extends Controller
{
    public function index()
    {
        // Vista para seleccionar reportes
        return view('pdf.index');
    }

    // Método genérico para crear PDFs con un conjunto de datos
    public function createPDF($data, $view, $type)
    {
        $date = date('Y-m-d');
        $pdf = PDF::loadView($view, ['data' => $data, 'date' => $date]);

        if($type == 1) {
            return $pdf->stream('reporte.pdf'); // Visualizar
        } else {
            return $pdf->download('reporte.pdf'); // Descargar
        }
    }

    // Reporte de productos
    public function productReport($type)
    {
        $view = "pdf.product_report";
        $products = Product::orderBy('Name')->get();
        return $this->createPDF($products, $view, $type);
    }

    // Reporte de factura/orden
    public function orderInvoice($type, $orderId)
    {
        $order = Order::with(['user', 'payment', 'shippingAddress', 'billingAddress'])
                      ->where('OrderId', $orderId)
                      ->first();

        $details = OrderDetail::with('product')
                         ->where('OrderId', $orderId)
                         ->get();

        // Usar el método específico para facturas
        return $this->createInvoicePDF($order, $details, $type);
    }

    // Método específico para crear PDFs de facturas
    protected function createInvoicePDF($order, $details, $type)
    {
        $date = date('Y-m-d');
        $pdf = PDF::loadView('pdf.order_invoice', [
            'order' => $order,
            'details' => $details,
            'date' => $date
        ]);

        if($type == 1) {
            return $pdf->stream('factura.pdf');
        } else {
            return $pdf->download('factura.pdf');
        }
    }
}
