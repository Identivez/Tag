<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index()
    {
        $payments = Payment::with(['order','user'])->get();
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        // Pedidos para el select
        $orders = Order::pluck('OrderId', 'OrderId');

        // Usuarios: combinamos firstName + lastName
        $users = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        return view('payments.create', compact('orders','users'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'OrderId'         => 'required|exists:orders,OrderId',
            'UserId'          => 'required|exists:users,UserId',
            'PaymentMethod'   => 'nullable|string|max:50',
            'Amount'          => 'nullable|numeric|min:0',
            'PaymentStatus'   => 'nullable|string|max:20',
            'TransactionDate' => 'nullable|date',
            'PaymentProvider' => 'nullable|string|max:50',
        ]);

        Payment::create($data);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Pago creado correctamente.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment)
    {
        $orders = Order::pluck('OrderId', 'OrderId');
        $users  = User::all()->mapWithKeys(function($u) {
            return [
                $u->UserId => "{$u->firstName} {$u->lastName}"
            ];
        });

        return view('payments.edit', compact('payment','orders','users'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'PaymentMethod'   => 'nullable|string|max:50',
            'Amount'          => 'nullable|numeric|min:0',
            'PaymentStatus'   => 'nullable|string|max:20',
            'TransactionDate' => 'nullable|date',
            'PaymentProvider' => 'nullable|string|max:50',
        ]);

        $payment->update($data);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Pago actualizado correctamente.');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('success', 'Pago eliminado correctamente.');
    }
}
