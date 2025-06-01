<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index()
    {
        $details = OrderDetail::with(['order','product'])->get();
        return view('order-details.index', compact('details'));
    }

    public function create()
    {
        $orders   = Order::pluck('OrderId','OrderId');
        $products = Product::pluck('Name','ProductId');
        return view('order-details.create', compact('orders','products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'OrderId'   => 'required|exists:orders,OrderId',
            'ProductId' => 'required|exists:products,ProductId',
            'Quantity'  => 'required|integer|min:1',
            'UnitPrice' => 'nullable|numeric|min:0',
            'CouponId'  => 'nullable|integer',
        ]);

        OrderDetail::create($data);

        return redirect()
            ->route('order-details.index')
            ->with('success', 'Detalle de pedido creado correctamente.');
    }

    public function show(OrderDetail $orderDetail)
    {
        return view('order-details.show', compact('orderDetail'));
    }

    public function edit(OrderDetail $orderDetail)
    {
        // No permitimos cambiar OrderId/ProductId en el edit
        return view('order-details.edit', compact('orderDetail'));
    }

    public function update(Request $request, OrderDetail $orderDetail)
    {
        $data = $request->validate([
            'Quantity'  => 'required|integer|min:1',
            'UnitPrice' => 'nullable|numeric|min:0',
            'CouponId'  => 'nullable|integer',
        ]);

        $orderDetail->update($data);

        return redirect()
            ->route('order-details.index')
            ->with('success', 'Detalle de pedido actualizado correctamente.');
    }

    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();

        return redirect()
            ->route('order-details.index')
            ->with('success', 'Detalle de pedido eliminado correctamente.');
    }
}
