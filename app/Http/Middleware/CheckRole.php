<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Verificar si hay sesión activa
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // Si no se requiere rol específico, continuar
        if (!$role) {
            return $next($request);
        }

        // Verificación directa por email (más confiable que roles en BD)
        $userEmail = $user->email;

        if ($role === 'admin') {
            // Solo admin@test.com puede ser admin
            if ($userEmail === 'admin@test.com') {
                return $next($request);
            }
        }

        if ($role === 'manager') {
            // admin y manager@test.com pueden ser managers
            if (in_array($userEmail, ['admin@test.com', 'manager@test.com'])) {
                return $next($request);
            }
        }

        // Si no tiene permisos
        return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta página');
    }
}
