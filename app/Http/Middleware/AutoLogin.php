<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AutoLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no hay usuario autenticado, autenticar automáticamente
        if (!Auth::check()) {
            // Buscar o crear un usuario de prueba
            $user = User::firstOrCreate(
                ['email' => 'admin@callcenter.com'],
                [
                    'name' => 'Admin CallCenter',
                    'password' => bcrypt('password')
                ]
            );
            
            Auth::login($user);
        }
        
        return $next($request);
    }
}
