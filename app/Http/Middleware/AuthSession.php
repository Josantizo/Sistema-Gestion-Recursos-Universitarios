<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSession
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si existe sesión de usuario
        if (!$request->session()->has('usuario')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder');
        }
        
        // Verificar si el usuario sigue activo
        $usuario = $request->session()->get('usuario');
        if ($usuario->estado !== 'activo') {
            $request->session()->forget(['usuario', 'usuario_id', 'usuario_rol']);
            return redirect()->route('login')->with('error', 'Tu cuenta está ' . $usuario->estado);
        }
        
        return $next($request);
    }
}