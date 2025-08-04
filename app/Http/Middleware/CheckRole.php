<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user()->rol !== $role) {
            // Si el rol del usuario no es el que se requiere,
            // lo redirigimos al dashboard principal.
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
