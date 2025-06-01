<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;

class EmailController extends Controller
{
    public function showContactForm()
    {
        return view('emails.contact_form');
    }

    public function sendContactEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Destinatario del correo (tu correo o el de soporte)
        $recipient = 'soporte@tusneakers.com';

        // Enviar el correo
        Mail::to($recipient)->send(new ContactFormMail($validated));

        return redirect()->back()->with('success', 'Tu mensaje ha sido enviado correctamente. Te responderemos a la brevedad.');
    }

    public function sendOrderConfirmation($orderId)
    {
        $order = Order::with(['user', 'orderDetails.product'])
                     ->findOrFail($orderId);

        // Enviar correo al usuario
        Mail::to($order->user->email)->send(new OrderConfirmationMail($order));

        return redirect()->back()->with('success', 'Se ha enviado el correo de confirmación al cliente.');
    }
}
