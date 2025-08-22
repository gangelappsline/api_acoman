<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRouteRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role; // admin, cliente, supervisor, etc.
        $currentRoute = $request->path(); // Ej: "admin/dashboard"

        // 2. Verificar si la ruta comienza con el nombre del rol
        $routePrefix = explode('/', $currentRoute)[0]; // Obtiene el primer segmento (ej: "admin")
        
        if ($routePrefix !== $userRole) {
            abort(403, 'No tienes permiso para acceder a esta ruta.');
        }

        return $next($request);
    }
}
