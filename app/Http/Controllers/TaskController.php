<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    // Afficher les tâches pour le membre
    public function index()
    {
        $user = Auth::user();
        $tasks = Task::where('user_id', $user->id)->with('project')->get();

        return view('tasks', compact('user', 'tasks'));
    }

    // Le Chef de Projet assigne une nouvelle tâche
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'estimated_days' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'expected_deliverables_count' => 'required|integer|min:1',
        ]);

        Task::create([
            'project_id' => $validated['project_id'],
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'estimated_days' => $validated['estimated_days'],
            'start_date' => $validated['start_date'],
            'due_date' => $validated['due_date'],
            'expected_deliverables_count' => $validated['expected_deliverables_count'],
            'uploaded_deliverables_count' => 0,
            'progress' => 0,
            'status' => 'en_cours',
        ]);

        return redirect()->back()->with('success', 'Tâche créée et assignée au membre avec succès.');
    }

    // Upload du livrable par le membre
    public function uploadDeliverable(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'deliverable_file' => 'required|file|mimes:pdf,zip,doc,docx,xlsx',
        ]);

        $path = $request->file('deliverable_file')->store('deliverables', 'public');
        $task->deliverable_file = $path;

        if ($task->uploaded_deliverables_count < $task->expected_deliverables_count) {
            $task->uploaded_deliverables_count += 1;
        }

        $task->progress = (int) round(($task->uploaded_deliverables_count / $task->expected_deliverables_count) * 100);

        if ($task->progress >= 100) {
            $task->status = 'termine';
        } else {
            $task->status = 'en_cours';
        }

        $task->save();

        return redirect()->back()->with('success', 'Livrable téléversé avec succès !');
    }

// Téléchargement sécurisé du livrable (Réservé au Chef de Projet et au membre assigné)
    public function downloadDeliverable($id)
    {
        $task = Task::findOrFail($id);
        $user = Auth::user();

        if (!$task->deliverable_file || !Storage::disk('public')->exists($task->deliverable_file)) {
            return redirect()->back()->with('error', 'Le fichier est introuvable sur le serveur.');
        }

        // Contrôle d'accès (Rôle / Autorisation)
        if ($user->id !== $task->user_id && $user->role !== 'chef_projet' && $user->role !== 'admin') {
            abort(403, 'Accès strictement non autorisé à ce livrable.');
        }

        // CORRECTION : Utiliser directement le chemin relatif ($task->deliverable_file)
        return Storage::disk('public')->download($task->deliverable_file);
    }

    // Téléchargement sécurisé du rapport d'évaluation (Réservé au Sponsor, Chef de Projet et Admin)
    public function downloadEvaluationReport($id)
    {
        $project = Project::findOrFail($id);
        $user = Auth::user();

        if (!$project->evaluation_report || !Storage::disk('public')->exists($project->evaluation_report)) {
            return redirect()->back()->with('error', 'Le rapport d\'évaluation est introuvable.');
        }

        // VÉRIFICATION DE SÉCURITÉ (RBAC) :
        // Seul le Sponsor associé, le Chef de Projet ou l'Admin peuvent ouvrir ce rapport sensible
        if ($user->id !== $project->sponsor_id && $user->role !== 'chef_projet' && $user->role !== 'admin') {
            abort(403, 'Accès strictement non autorisé à ce rapport d\'évaluation.');
        }

        // CORRECTION : Utiliser uniquement le chemin relatif du fichier
        return Storage::disk('public')->download($project->evaluation_report);
    }

    // Mettre à jour l'état d'une tâche
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        
        if ($request->has('status')) {
            $task->status = $request->input('status');
        }

        if ($request->has('blockage_reason')) {
            $task->blockage_reason = $request->input('blockage_reason');
            $task->status = 'bloque';
        }

        $task->save();

        return redirect()->back()->with('success', 'Mise à jour enregistrée avec succès.');
    }
}