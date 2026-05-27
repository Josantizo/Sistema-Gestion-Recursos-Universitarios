<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DocenteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $usuario = $request->session()->get('usuario');
        
        if (!$usuario || ($usuario->rol !== 'docente' && $usuario->rol !== 'administrador')) {
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado. Se requieren permisos de docente');
        }
        
        return $next($request);
    }
}
