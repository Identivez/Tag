<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders (admin view).
     */
    public function index()
    {
        $orders = Order::with(['user','payment','shippingAddress','billingAddress'])->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Display orders for the current authenticated user.
     */
    public function userOrders()
    {
        $orders = Order::where('UserId', Auth::id())
            ->with(['payment', 'shippingAddress', 'billingAddress'])
            ->orderBy('OrderDate', 'desc')
            ->get();

        return view('orders.user-orders', compact('orders'));
    }

    /**
     * Show the checkout form for the current user's cart.
     */
    public function checkout()
    {
        // Obtener los items del carrito del usuario actual
        $cartItems = CartItem::where('UserId', Auth::id())
            ->with('product')
            ->get();

        // Verificar si el carrito está vacío
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')
                ->with('error', 'Tu carrito está vacío. Agrega productos antes de proceder al checkout.');
        }

        // Calcular totales
        $subtotal = $cartItems->sum('Total');
        $shippingCost = 20.00; // Costo de envío por defecto, podría calcularse dinámicamente
        $total = $subtotal + $shippingCost;

        // Obtener direcciones del usuario para envío/facturación
        $addresses = Address::where('UserId', Auth::id())
            ->where('IsActive', true)
            ->get();

        // Verificar si el usuario tiene direcciones
        if ($addresses->isEmpty()) {
            return redirect()->route('addresses.create')
                ->with('info', 'Por favor, agrega al menos una dirección antes de realizar un pedido.');
        }

        return view('orders.checkout', compact(
            'cartItems',
            'subtotal',
            'shippingCost',
            'total',
            'addresses'
        ));
    }

    /**
     * Process the order from checkout.
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'ShippingAddressId' => 'required|exists:addresses,AddressId',
            'BillingAddressId' => 'required|exists:addresses,AddressId',
            'PaymentMethod' => 'required|string|max:50',
            // Otros campos según sea necesario
        ]);

        // Obtener items del carrito
        $cartItems = CartItem::where('UserId', Auth::id())
            ->with('product')
            ->get();

        // Verificar si el carrito está vacío
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')
                ->with('error', 'Tu carrito está vacío. Agrega productos antes de proceder al checkout.');
        }

        // Calcular totales
        $subtotal = $cartItems->sum('Total');
        $shippingCost = 20.00; // Podría ser dinámico
        $orderTotal = $subtotal + $shippingCost;

        // Iniciar transacción para asegurar integridad de datos
        DB::beginTransaction();

        try {
            // Crear el pedido
            $order = Order::create([
                'UserId' => Auth::id(),
                'OrderDate' => now(),
                'TotalAmount' => $orderTotal,
                'OrderStatus' => 'Pendiente',
                'ShippingMethod' => 'Estándar',
                'ShippingCost' => $shippingCost,
                'ShippingAddressId' => $validated['ShippingAddressId'],
                'BillingAddressId' => $validated['BillingAddressId'],
                'CreatedAt' => now(),
                'UpdatedAt' => now(),
            ]);

            // Crear registro de pago
            $payment = Payment::create([
                'OrderId' => $order->OrderId,
                'UserId' => Auth::id(),
                'PaymentMethod' => $validated['PaymentMethod'],
                'Amount' => $orderTotal,
                'PaymentStatus' => 'Pendiente',
                'TransactionDate' => now(),
                'PaymentProvider' => $validated['PaymentMethod'] == 'Tarjeta de Crédito' ? 'Stripe' : $validated['PaymentMethod'],
            ]);

            // Actualizar pedido con ID de pago
            $order->update(['PaymentId' => $payment->PaymentId]);

            // Crear detalles del pedido a partir de los items del carrito
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'OrderId' => $order->OrderId,
                    'ProductId' => $item->ProductId,
                    'Quantity' => $item->Quantity,
                    'UnitPrice' => $item->Price,
                ]);

                // Actualizar stock si es necesario
                $product = $item->product;
                if ($product->Stock >= $item->Quantity) {
                    $product->Stock -= $item->Quantity;
                    $product->save();
                }
            }

            // Limpiar el carrito del usuario
            CartItem::where('UserId', Auth::id())->delete();

            // Confirmar transacción
            DB::commit();

            // Redirigir a la confirmación del pedido
            return redirect()->route('orders.confirmation', $order->OrderId)
                ->with('success', 'Tu pedido ha sido procesado correctamente.');

        } catch (\Exception $e) {
            // Revertir la transacción si hay errores
            DB::rollBack();

            // Registrar el error para diagnóstico
            //\Log::error('Error al procesar pedido: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Hubo un error al procesar tu pedido. Por favor, inténtalo de nuevo más tarde.');
        }

    }

    /**
     * Display the order confirmation.
     */
    public function confirmation($orderId)
    {
        $order = Order::where('OrderId', $orderId)
            ->where('UserId', Auth::id()) // Asegurar que el pedido pertenece al usuario actual
            ->with(['payment', 'shippingAddress', 'billingAddress', 'orderDetails.product'])
            ->firstOrFail();

        return view('orders.confirmation', compact('order'));
    }

    /**
     * Show the form for creating a new resource (admin).
     */
    public function create()
    {
        // Construye [UserId => "First Last"] para el dropdown
        $users = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        $payments  = Payment::pluck('PaymentId', 'PaymentId');
        $addresses = Address::pluck('AddressLine1', 'AddressId');

        return view('orders.create', compact('users','payments','addresses'));
    }

    /**
     * Store a newly created resource in storage (admin).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'UserId'             => 'required|exists:users,UserId',
            'OrderDate'          => 'nullable|date',
            'TotalAmount'        => 'nullable|numeric|min:0',
            'OrderStatus'        => 'nullable|string|max:20',
            'PaymentId'          => 'nullable|exists:payments,PaymentId',
            'ShippingMethod'     => 'nullable|string|max:50',
            'ShippingCost'       => 'nullable|numeric|min:0',
            'ShippingAddressId'  => 'nullable|exists:addresses,AddressId',
            'BillingAddressId'   => 'nullable|exists:addresses,AddressId',
        ]);

        // Establecer valores por defecto si no se proporcionan
        if (!isset($data['OrderDate'])) {
            $data['OrderDate'] = now();
        }

        if (!isset($data['OrderStatus'])) {
            $data['OrderStatus'] = 'Pendiente';
        }

        $order = Order::create($data);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pedido creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Cargar relaciones para mostrar detalles completos
        $order->load(['user', 'payment', 'shippingAddress', 'billingAddress', 'orderDetails.product']);

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $users = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        $payments  = Payment::pluck('PaymentId', 'PaymentId');
        $addresses = Address::pluck('AddressLine1', 'AddressId');

        return view('orders.edit', compact('order','users','payments','addresses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'OrderDate'          => 'nullable|date',
            'TotalAmount'        => 'nullable|numeric|min:0',
            'OrderStatus'        => 'nullable|string|max:20',
            'PaymentId'          => 'nullable|exists:payments,PaymentId',
            'ShippingMethod'     => 'nullable|string|max:50',
            'ShippingCost'       => 'nullable|numeric|min:0',
            'ShippingAddressId'  => 'nullable|exists:addresses,AddressId',
            'BillingAddressId'   => 'nullable|exists:addresses,AddressId',
        ]);

        // Actualizar también el campo UpdatedAt
        $data['UpdatedAt'] = now();

        $order->update($data);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    /**
     * Cancel an order by the user.
     */
    public function cancelOrder($orderId)
    {
        $order = Order::where('OrderId', $orderId)
            ->where('UserId', Auth::id())
            ->firstOrFail();

        // Verificar si el pedido puede ser cancelado (por ejemplo, si no ha sido enviado aún)
        if ($order->OrderStatus == 'Enviado' || $order->OrderStatus == 'Entregado' || $order->OrderStatus == 'Cancelado') {
            return redirect()->back()
                ->with('error', 'Este pedido no puede ser cancelado en su estado actual.');
        }

        // Iniciar transacción
        DB::beginTransaction();

        try {
            // Actualizar estado del pedido
            $order->OrderStatus = 'Cancelado';
            $order->UpdatedAt = now();
            $order->save();

            // Actualizar estado del pago si existe
            if ($order->payment) {
                $order->payment->PaymentStatus = 'Cancelado';
                $order->payment->save();
            }

            // Restaurar inventario si es necesario
            $orderDetails = $order->orderDetails;
            if ($orderDetails) {
                foreach ($orderDetails as $detail) {
                    $product = $detail->product;
                    if ($product) {
                        $product->Stock += $detail->Quantity;
                        $product->save();
                    }
                }
            }

            // Confirmar transacción
            DB::commit();

            return redirect()->route('orders.user')
                ->with('success', 'Tu pedido ha sido cancelado correctamente.');

        } catch (\Exception $e) {
            // Revertir transacción si hay errores
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Hubo un error al cancelar tu pedido. Por favor, inténtalo de nuevo más tarde.');
        }
    }

    /**
     * Remove the specified resource from storage (admin).
     */
    public function destroy(Order $order)
    {
        // Esta acción debe usarse con precaución, ya que elimina permanentemente el pedido
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }
}
