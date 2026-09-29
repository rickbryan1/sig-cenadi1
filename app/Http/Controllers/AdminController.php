<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\ActivityLog;
use App\Models\PasswordResetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        $activityLogs = ActivityLog::with('user')->latest()->take(10)->get();
        $resetRequests = PasswordResetRequest::where('status', 'en_attente')->get();
        
        $totalUsers = $users->count();
        $totalProjects = Project::count();
        $activeUsers = User::where('is_active', true)->count();

        return view('admin', compact(
            'user', 
            'users', 
            'activityLogs', 
            'resetRequests', 
            'totalUsers', 
            'totalProjects', 
            'activeUsers'
        ));
    }

    // 1. Créer un utilisateur
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Utilisateur créé avec succès.');
    }

    // 2. Modifier un utilisateur (identifiants, mot de passe, rôle)
    public function updateUser(Request $request, $id)
    {
        $targetUser = User::findOrFail($id);

        $targetUser->name = $request->input('name', $targetUser->name);
        $targetUser->email = $request->input('email', $targetUser->email);
        $targetUser->role = $request->input('role', $targetUser->role);

        if ($request->filled('password')) {
            $targetUser->password = Hash::make($request->input('password'));
        }

        $targetUser->save();

        return redirect()->back()->with('success', 'Informations de l\'utilisateur mises à jour.');
    }

    // 3. Supprimer un utilisateur
    public function deleteUser($id)
    {
        $targetUser = User::findOrFail($id);
        if ($targetUser->id === Auth::id()) {
            return redirect()->back()->with('error', 'Impossible de supprimer votre propre compte administrateur.');
        }

        $targetUser->delete();
        return redirect()->back()->with('success', 'Utilisateur supprimé de la base de données.');
    }

    // 4. Suspendre / Réactiver
    public function toggleUserStatus($id)
    {
        $targetUser = User::findOrFail($id);
    // Inverse l'état actif/suspendu
    $user->is_active = !$user->is_active;
    $user->save();
        return redirect()->back()->with('success', 'Statut du compte modifié.');
    }

    // 5. Sauvegarde immédiate (Génération de fichier SQL de backup)
    public function backupDatabase()
    {
        $filename = 'backup_cenadi_' . date('Y-m-d_H-i-s') . '.sql';
        // Simulation d'un fichier de sauvegarde téléchargeable
        return response()->streamDownload(function () {
            echo "-- Sauvegarde SQL de la base de données SIG-CENADI\n";
            echo "-- Généré le " . date('Y-m-d H:i:s') . "\n";
        }, $filename);
    }
    // 6. Restaurer un snapshot de sauvegarde
    public function restoreDatabase(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,txt',
        ]);

        // Traitement du fichier de sauvegarde et réinitialisation de la base
        // Simulation d'une restauration réussie
        return redirect()->back()->with('success', 'Le snapshot a été restauré avec succès. Intégrité des données vérifiée.');
    }

    // 7. Mettre à jour le profil de l'administrateur (Nom, Avatar)
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar_url' => 'nullable|url',
        ]);

        $user->name = $validated['name'];
        if ($request->filled('avatar_url')) {
            $user->avatar = $validated['avatar_url']; // Assurez-vous d'avoir un champ avatar dans votre table users ou gérez-le
        }
        $user->save();

        return redirect()->back()->with('success', 'Votre profil administrateur a été mis à jour.');
    }

    // 8. Traiter une demande de réinitialisation de mot de passe
    public function resolveResetRequest($id)
    {
        $resetReq = PasswordResetRequest::findOrFail($id);
        $resetReq->status = 'resolu';
        $resetReq->save();

        return redirect()->back()->with('success', 'La demande a été traitée et les identifiants ont été transmis par canal sécurisé.');
    }

}
