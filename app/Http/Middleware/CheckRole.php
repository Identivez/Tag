<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
   public function handle(Request $request, Closure $next, $roles = null)
{
    if (!Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();
    $userEmail = $user->email;

    if (!$roles) {
        return $next($request);
    }

    // Dividir los roles por "|" para permitir múltiples
    $rolesArray = explode('|', $roles);

    // Lógica personalizada basada en email
    $allowedEmails = [];

    if (in_array('admin', $rolesArray)) {
        $allowedEmails[] = 'admin@test.com';
    }

    if (in_array('manager', $rolesArray)) {
        $allowedEmails[] = 'manager@test.com';
    }

    if (in_array($userEmail, $allowedEmails)) {
        return $next($request);
    }

    return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta página');
}

}
