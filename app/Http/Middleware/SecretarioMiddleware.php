<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecretarioMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('usuario') || session('usuario')->rol !== 'secretario') {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
