<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('admin.ingresar');
        }

        if (!$request->user()->is_admin) {
            return redirect()->route('home')
                ->with('error', 'No tenés permisos de administrador.');
        }

        return $next($request);
    }
}
