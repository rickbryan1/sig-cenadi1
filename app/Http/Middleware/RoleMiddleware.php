<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Vérifier si l'utilisateur a le bon rôle
        if ($user->role !== $role) {
            // Redirection vers son propre espace s'il tente d'accéder à un autre
            if ($user->role === 'admin') return redirect('/admin');
            if ($user->role === 'chef_projet') return redirect('/dashboard');
            if ($user->role === 'member') return redirect('/tasks');
            if ($user->role === 'sponsor') return redirect('/sponsor');
            
            return redirect('/login');
        }

        return $next($request);
    }
}