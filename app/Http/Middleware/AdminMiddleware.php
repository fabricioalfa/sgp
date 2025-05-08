<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si hay usuario en sesión
        if (session()->has('usuario') && session('usuario')->rol === 'administrador') {
            return $next($request);
        }

        // Si no es administrador, denegar acceso
        abort(403, 'Acceso no autorizado');
    }
}

