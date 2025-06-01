<?php
// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Verificar si hay sesión activa
        if (!$request->session()->has('login_web_' . sha1('App\Models\User'))) {
            return redirect('/login');
        }

        // Obtener ID del usuario de la sesión
        $userId = $request->session()->get('login_web_' . sha1('App\Models\User'));

        if (!$userId) {
            return redirect('/login');
        }

        // Si no se requiere rol específico, continuar
        if (!$role) {
            return $next($request);
        }

        // Verificación básica por email desde sesión
        $userEmail = $request->session()->get('user_email');

        if ($role === 'admin') {
            // Solo admin@test.com puede ser admin
            if ($userEmail === 'admin@test.com') {
                return $next($request);
            }
        }

        if ($role === 'manager') {
            // admin y manager@test.com pueden ser managers
            if ($userEmail === 'admin@test.com' || $userEmail === 'manager@test.com') {
                return $next($request);
            }
        }

        // Si no tiene permisos
        return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta página');
    }
}
