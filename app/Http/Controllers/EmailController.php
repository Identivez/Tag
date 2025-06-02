<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\ContactFormMail;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\User;

class EmailController extends Controller
{
    /**
     * Muestra el formulario de contacto público
     */
    public function showContactForm()
    {
        return view('contact');
    }

    /**
     * Envía email desde formulario de contacto público
     */
    public function sendContactEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Destinatario del correo (soporte de TAG & SOLE)
            $recipient = 'l21281040@toluca.tecnm.mx';

            // Enviar el correo usando la clase Mail
            Mail::to($recipient)->send(new ContactFormMail($validated));

            return redirect()->back()->with('success', 'Tu mensaje ha sido enviado correctamente. Te responderemos a la brevedad.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al enviar el correo: ' . $e->getMessage());
        }
    }

    /**
     * Muestra formulario de envío de correos (ADMIN)
     */
    public function showAdminEmailForm()
    {
        try {
            // Obtener usuarios para el select de forma más robusta
            $users = User::select('UserId', 'firstName', 'lastName', 'email')
                        ->whereNotNull('email')
                        ->orderBy('firstName')
                        ->get();
        } catch (\Exception $e) {
            // Si hay error en BD, crear colección vacía
            $users = collect();
        }

        return view('admin.emails.form', compact('users'));
    }

    /**
     * Envía correo desde panel de administración
     */
    public function sendAdminEmail(Request $request)
    {
        $validated = $request->validate([
            'destinatario' => 'required|email',
            'asunto' => 'required|string|max:255',
            'contenido_mail' => 'required|string',
        ]);

        try {
            // VERSIÓN SIMPLIFICADA - Sin usar auth()->user()
            $remitenteName = 'Administrador TAG & SOLE';
            $remitenteEmail = 'l21281040@toluca.tecnm.mx';

            // Intentar obtener datos del usuario de forma segura
            try {
                if (Auth::check()) {
                    $user = Auth::user();
                    if ($user && isset($user->firstName)) {
                        $firstName = $user->firstName ?? '';
                        $lastName = $user->lastName ?? '';
                        $fullName = trim($firstName . ' ' . $lastName);

                        if (!empty($fullName)) {
                            $remitenteName = $fullName;
                        }

                        if (!empty($user->email)) {
                            $remitenteEmail = $user->email;
                        }
                    }
                }
            } catch (\Exception $e) {
                // Si hay error obteniendo el usuario, usar valores por defecto
                // Ya están configurados arriba
            }

            // Datos para la vista
            $emailData = [
                'destinatario' => $validated['destinatario'],
                'asunto' => $validated['asunto'],
                'contenido' => $validated['contenido_mail'],
                'remitente' => $remitenteName,
                'email_remitente' => $remitenteEmail,
                'fecha' => now()->format('d/m/Y H:i:s')
            ];

            // Enviar correo usando vista personalizada
            Mail::send('admin.emails.plantilla_correo', $emailData, function ($message) use ($validated) {
                $message->from('l21281040@toluca.tecnm.mx', 'TAG & SOLE Administración');
                $message->to($validated['destinatario'])
                        ->subject($validated['asunto']);
            });

            return view('admin.emails.mensaje')
                ->with('var', '1')
                ->with('msj', 'Correo enviado correctamente a: ' . $validated['destinatario'])
                ->with('ruta_boton', 'admin.emails.form')
                ->with('mensaje_boton', 'Enviar Otro Correo');

        } catch (\Exception $e) {
            return view('admin.emails.mensaje')
                ->with('var', '2')
                ->with('msj', 'Error al enviar el correo: ' . $e->getMessage())
                ->with('ruta_boton', 'admin.emails.form')
                ->with('mensaje_boton', 'Intentar de Nuevo');
        }
    }

    /**
     * Envía confirmación de pedido al cliente (VERSIÓN MÁS SIMPLE)
     */
    public function sendOrderConfirmation($orderId)
    {
        try {
            // Buscar pedido de forma simple
            $order = Order::find($orderId);

            if (!$order) {
                return $this->errorResponse('Pedido no encontrado');
            }

            // Buscar usuario de forma independiente y segura
            $user = null;
            $userEmail = null;
            $userName = 'Estimado cliente';

            if (!empty($order->UserId)) {
                try {
                    $user = User::find($order->UserId);
                    if ($user) {
                        $userEmail = $user->email;
                        $firstName = $user->firstName ?? '';
                        $lastName = $user->lastName ?? '';
                        $fullName = trim($firstName . ' ' . $lastName);

                        if (!empty($fullName)) {
                            $userName = $fullName;
                        }
                    }
                } catch (\Exception $e) {
                    // Si hay error buscando usuario, continuar con valores por defecto
                }
            }

            if (empty($userEmail)) {
                return $this->errorResponse('No se puede enviar el correo: email del usuario no válido');
            }

            // Crear datos simples para el email
            $emailData = [
                'order' => (object)[
                    'OrderId' => $order->OrderId,
                    'UserId' => $order->UserId,
                    'OrderDate' => $order->OrderDate,
                    'TotalAmount' => $order->TotalAmount ?? 0,
                    'OrderStatus' => $order->OrderStatus ?? 'Pendiente',
                    'ShippingCost' => $order->ShippingCost ?? 0,
                ],
                'userName' => $userName,
                'userEmail' => $userEmail,
                'fecha' => now()->format('d/m/Y H:i:s')
            ];

            // Enviar usando vista simple
            Mail::send('emails.order-confirmation-simple', $emailData, function ($message) use ($userEmail, $order) {
                $message->from('l21281040@toluca.tecnm.mx', 'TAG & SOLE Pedidos');
                $message->to($userEmail);
                $message->subject('Confirmación de Pedido #' . $order->OrderId . ' - TAG & SOLE');
            });

            return $this->successResponse('Se ha enviado el correo de confirmación a: ' . $userEmail);

        } catch (\Exception $e) {
            return $this->errorResponse('Error al enviar correo de confirmación: ' . $e->getMessage());
        }
    }

    /**
     * Envía confirmación usando la clase Mail (AJAX) - VERSIÓN SIMPLIFICADA
     */
    public function sendOrderConfirmationAjax($orderId)
    {
        try {
            // Buscar pedido
            $order = Order::find($orderId);
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
            }

            // Buscar usuario de forma segura
            $userEmail = null;
            if (!empty($order->UserId)) {
                try {
                    $user = User::find($order->UserId);
                    if ($user && !empty($user->email)) {
                        $userEmail = $user->email;
                    }
                } catch (\Exception $e) {
                    // Error buscando usuario
                }
            }

            if (empty($userEmail)) {
                return response()->json(['success' => false, 'message' => 'Email del usuario no válido'], 400);
            }

            // Enviar usando la clase Mail
            Mail::to($userEmail)->send(new OrderConfirmationMail($order));

            return response()->json([
                'success' => true,
                'message' => 'Confirmación enviada a: ' . $userEmail
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Envía correo de bienvenida a nuevo usuario
     */
    public function sendWelcomeEmail($userId)
    {
        try {
            $user = User::find($userId);

            if (!$user || empty($user->email)) {
                return $this->errorResponse('Usuario no encontrado o sin email válido');
            }

            // Preparar datos de forma segura
            $firstName = $user->firstName ?? '';
            $lastName = $user->lastName ?? '';
            $fullName = trim($firstName . ' ' . $lastName);

            if (empty($fullName)) {
                $fullName = 'Estimado cliente';
            }

            $emailData = [
                'usuario' => $fullName,
                'email' => $user->email,
                'fecha_registro' => isset($user->createdAt) ? $user->createdAt->format('d/m/Y') : 'N/A',
                'fecha' => now()->format('d/m/Y H:i:s')
            ];

            Mail::send('admin.emails.welcome', $emailData, function ($message) use ($user) {
                $message->from('l21281040@toluca.tecnm.mx', 'TAG & SOLE')
                        ->to($user->email)
                        ->subject('¡Bienvenido a TAG & SOLE! Tu cuenta ha sido creada');
            });

            return $this->successResponse('Correo de bienvenida enviado a: ' . $user->email);

        } catch (\Exception $e) {
            return $this->errorResponse('Error al enviar correo de bienvenida: ' . $e->getMessage());
        }
    }

    /**
     * Muestra vista de prueba de correos (para testing)
     */
    public function testEmail()
    {
        try {
            $testData = [
                'name' => 'Usuario de Prueba',
                'email' => 'ghaelg18@gmail.com',
                'subject' => 'Correo de Prueba - Sistema TAG & SOLE',
                'message' => 'Este es un correo de prueba desde TAG & SOLE. Si recibes este mensaje, el sistema de correos está funcionando correctamente.'
            ];

            // Enviar a un email de prueba
            Mail::to('ghaelg18@gmail.com')->send(new ContactFormMail($testData));

            return response()->json([
                'success' => true,
                'message' => 'Correo de prueba enviado correctamente a admin@test.com'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en prueba de correo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vista de historial de correos (placeholder)
     */
    public function emailHistory()
    {
        // Estadísticas básicas
        $stats = [
            'total_sent' => 0,
            'total_failed' => 0,
            'last_sent' => 'N/A'
        ];

        return view('admin.emails.history', compact('stats'));
    }

    /**
     * Envío masivo de correos (placeholder)
     */
    public function bulkEmail(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_ids' => 'required|array',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            $successCount = 0;
            $failedCount = 0;

            foreach ($validated['user_ids'] as $userId) {
                try {
                    $user = User::find($userId);
                    if ($user && !empty($user->email)) {
                        // Lógica de envío masivo aquí
                        $successCount++;
                    }
                } catch (\Exception $e) {
                    $failedCount++;
                    continue;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Envío masivo completado. Enviados: {$successCount}, Fallidos: {$failedCount}"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en envío masivo: ' . $e->getMessage()
            ], 500);
        }
    }

    // Métodos auxiliares para respuestas consistentes

    private function successResponse($message)
    {
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->back()->with('success', $message);
    }

    private function errorResponse($message)
    {
        if (request()->expectsJson()) {
            return response()->json(['success' => false, 'message' => $message], 400);
        }
        return redirect()->back()->with('error', $message);
    }
}
