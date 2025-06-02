<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Guardar email en sesión para el middleware
            $request->session()->put('user_email', $request->email);

            // Redirigir según el rol del usuario
            $redirect = $this->redirectByRole();
            return $redirect->with('success', 'Bienvenido al sistema');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Mostrar formulario de registro
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.register');
    }

    // Procesar registro
    public function register(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Guardar email en sesión
        $request->session()->put('user_email', $request->email);

        // Los nuevos usuarios siempre van al dashboard normal
        return redirect()->route('dashboard')->with('success', 'Registro exitoso');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Sesión cerrada correctamente');
    }

    /**
     * Redirige al usuario según su rol (basado en email)
     */
    private function redirectByRole()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        // Verificación directa por email (más confiable)
        $email = $user->email;

        // Admin
        if ($email === 'admin@test.com') {
            return redirect()->route('admin.dashboard');
        }

        // Manager
        if ($email === 'manager@test.com') {
            return redirect()->route('dashboard');
        }

        // Usuario normal
        return redirect()->route('dashboard');
    }

    /**
     * Verificar si el usuario es admin (método estático)
     */
    public static function isUserAdmin($user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return false;
        }

        return $user->email === 'admin@test.com';
    }

    /**
     * Verificar si el usuario es manager (método estático)
     */
    public static function isUserManager($user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return false;
        }

        return in_array($user->email, ['admin@test.com', 'manager@test.com']);
    }

    /**
     * Método para cambiar manualmente entre dashboards (opcional)
     */
    public function switchDashboard(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        // Verificación directa por email
        if ($user->email !== 'admin@test.com') {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder al panel de administración.');
        }

        $type = $request->get('type', 'normal');

        if ($type === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }
}
