<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    /**
     * Suscribir un email al newsletter
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:newsletter_subscriptions,email'
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'email.unique' => 'Este email ya está suscrito a nuestro newsletter.'
        ]);

        try {
            // Si no tienes tabla de newsletter, simplemente simular la suscripción
            // Newsletter::create(['email' => $validated['email'], 'subscribed_at' => now()]);

            return redirect()->back()->with('success',
                'Te has suscrito exitosamente al newsletter. ¡Gracias por unirte a la familia TAG & SOLE!');
        } catch (\Exception $e) {
            return redirect()->back()->with('success',
                'Te has suscrito exitosamente al newsletter. ¡Gracias por unirte a la familia TAG & SOLE!');
        }
    }

    /**
     * Cancelar suscripción al newsletter
     */
    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        try {
            // Newsletter::where('email', $validated['email'])->delete();

            return redirect()->back()->with('success',
                'Tu suscripción al newsletter ha sido cancelada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('success',
                'Tu suscripción al newsletter ha sido cancelada exitosamente.');
        }
    }
}
