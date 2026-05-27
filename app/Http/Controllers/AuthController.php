<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        // Validar datos
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|min:6'
        ], [
            'correo.required' => 'El correo es obligatorio',
            'correo.email' => 'Ingresa un correo válido',
            'contrasena.required' => 'La contraseña es obligatoria',
            'contrasena.min' => 'La contraseña debe tener al menos 6 caracteres'
        ]);

        // Buscar usuario por correo
        $usuario = Usuario::where('correo', $request->correo)->first();

        // Verificar credenciales
        if ($usuario && Hash::check($request->contrasena, $usuario->contrasena)) {
            
            // Verificar estado del usuario
            if ($usuario->estado !== 'activo') {
                return back()->with('error', 'Tu cuenta está ' . $usuario->estado . '. Contacta al administrador.');
            }
            
            // Guardar usuario en sesión
            session(['usuario' => $usuario]);
            session(['usuario_id' => $usuario->id_usuario]);
            session(['usuario_rol' => $usuario->rol]);
            
            // Registrar en historial
            Historial::registrar(
                $usuario->id_usuario,
                'login',
                $usuario->correo,
                "Inicio de sesión exitoso"
            );
            
            // Redirigir según rol
            if ($usuario->rol === 'administrador') {
                return redirect()->route('admin.dashboard')->with('success', 'Bienvenido al panel de administración');
            } elseif ($usuario->rol === 'docente') {
                return redirect()->route('docente.dashboard')->with('success', '¡Bienvenido ' . $usuario->nombre . '!');
            }
            
            return redirect()->route('dashboard')->with('success', '¡Bienvenido ' . $usuario->nombre . '!');
        }

        return back()->with('error', 'Correo o contraseña incorrectos');
    }

    // Mostrar formulario de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function register(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:6|confirmed'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'apellido.required' => 'El apellido es obligatorio',
            'correo.required' => 'El correo es obligatorio',
            'correo.email' => 'Ingresa un correo válido',
            'correo.unique' => 'Este correo ya está registrado',
            'contrasena.required' => 'La contraseña es obligatoria',
            'contrasena.min' => 'La contraseña debe tener al menos 6 caracteres',
            'contrasena.confirmed' => 'Las contraseñas no coinciden'
        ]);

        // Crear usuario
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'contrasena' => $request->contrasena, // Se encripta automáticamente
            'rol' => 'estudiante',
            'estado' => 'activo'
        ]);

        // Iniciar sesión automáticamente
        session(['usuario' => $usuario]);
        session(['usuario_id' => $usuario->id_usuario]);
        session(['usuario_rol' => $usuario->rol]);
        
        // Registrar en historial
        Historial::registrar(
            $usuario->id_usuario,
            'registro',
            $usuario->correo,
            "Nuevo usuario registrado"
        );
        
        return redirect()->route('dashboard')->with('success', 'Registro exitoso. ¡Bienvenido!');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        // Registrar cierre de sesión
        if (session('usuario')) {
            Historial::registrar(
                session('usuario')->id_usuario,
                'logout',
                session('usuario')->correo,
                "Cierre de sesión"
            );
        }
        
        // Limpiar sesión
        session()->forget(['usuario', 'usuario_id', 'usuario_rol']);
        
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente');
    }
}