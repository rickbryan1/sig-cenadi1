<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordResetRequest;
use App\Models\Task; // Pour récupérer les tâches bloquées
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 1. Demandes de réinitialisation de mot de passe en attente (Sécurité)
        $resetRequests = PasswordResetRequest::where('status', 'en_attente')->latest()->get();
        
        // 2. Tâches signalées comme bloquées (Blocages)
        $blockedTasks = Task::where('status', 'bloque')->with('project', 'user')->latest()->get();

        // 3. Compteur total dynamique pour le badge de notification
        $totalAlertsCount = $resetRequests->count() + $blockedTasks->count();

        return view('alerts', compact('user', 'resetRequests', 'blockedTasks', 'totalAlertsCount'));
    }
}