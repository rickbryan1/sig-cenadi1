<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    // Afficher la page de connexion
    public function showLoginForm()
    {
        return view('login');
    }

    // Traiter la soumission du formulaire de connexion
    public function login(Request $request)
    {
        // Validation des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirection selon le rôle de l'utilisateur
            if ($user->role === 'admin') {
                return redirect()->intended('/admin');
            } elseif ($user->role === 'chef_projet') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role === 'member') {
                return redirect()->intended('/tasks');
            } elseif ($user->role === 'sponsor') {
                return redirect()->intended('/sponsor');
            }

            return redirect()->intended('/dashboard');
        }

        if (Auth::attempt($credentials, $request->has('remember'))) {
    $request->session()->regenerate();
    $user = Auth::user();

    // Enregistrement dans le journal d'activité
    ActivityLog::create([
        'user_id' => $user->id,
        'action' => 'Connexion au système',
        'ip_address' => $request->ip(),
    ]);

    // Redirections par rôle...
    if ($user->role === 'admin') return redirect()->intended('/admin');
    if ($user->role === 'chef_projet') return redirect()->intended('/dashboard');
    if ($user->role === 'member') return redirect()->intended('/tasks');
    if ($user->role === 'sponsor') return redirect()->intended('/sponsor');
    
    return redirect()->intended('/dashboard');
}

        // Si échec, retour en arrière avec erreur
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}