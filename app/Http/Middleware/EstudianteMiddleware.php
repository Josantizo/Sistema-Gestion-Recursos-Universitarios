<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EstudianteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $usuario = $request->session()->get('usuario');
        
        if (!$usuario || ($usuario->rol !== 'estudiante' && $usuario->rol !== 'administrador')) {
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado. Solo los estudiantes pueden realizar reservas.');
        }
        
        return $next($request);
    }
}
