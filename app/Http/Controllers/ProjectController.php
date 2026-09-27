<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // Afficher le tableau de bord du Chef de Projet avec ses projets
public function index()
{
    $user = Auth::user();
    
    $projects = Project::where('user_id', $user->id)->with('tasks', 'members', 'sponsor')->get();
    
    // Récupérer la liste des membres et des sponsors pour le Wizard
    $members = User::where('role', 'member')->get();
    $sponsors = User::where('role', 'sponsor')->get();
    
    $totalProjects = $projects->count();
    $totalBudgetAllocated = $projects->sum('budget_allocated');
    $totalActualCost = 0; 
    $budgetConsumptionRate = $totalBudgetAllocated > 0 ? ($totalActualCost / $totalBudgetAllocated) * 100 : 0;

    return view('dashboard', compact(
        'user', 
        'projects', 
        'members', 
        'sponsors', 
        'totalProjects', 
        'totalBudgetAllocated', 
        'totalActualCost', 
        'budgetConsumptionRate'
    ));
}
    // Enregistrer un nouveau projet dans la base de données
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'objectives' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'budget_allocated' => 'required|numeric|min:0',
        'resources' => 'nullable|string',
        'sponsor_id' => 'required|exists:users,id',
        'members' => 'nullable|array', // Tableau des IDs des membres cochés
    ]);

    $project = Project::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'objectives' => $validated['objectives'] ?? null,
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
        'budget_allocated' => $validated['budget_allocated'],
        'resources' => $validated['resources'] ?? null,
        'sponsor_id' => $validated['sponsor_id'],
        'status' => 'brouillon',
        'user_id' => Auth::id(),
    ]);

    // Attacher les membres sélectionnés par cases à cocher
    if (!empty($validated['members'])) {
        $project->members()->sync($validated['members']);
    }

    return redirect()->back()->with('success', 'Projet initialisé avec succès ! Vous pouvez maintenant procéder à l\'assignation des tâches.');
}

// Envoyer au commanditaire (Sponsor) pour validation
public function sendToSponsor($id)
{
    $project = Project::findOrFail($id);
    $project->status = 'en_attente_validation';
    $project->save();

    return redirect()->back()->with('success', 'Projet transmis au commanditaire (Sponsor) pour vérification.');
}
public function submitEvaluation(Request $request, $id)
{
    $project = Project::findOrFail($id);
    
    $request->validate([
        'evaluation_report' => 'required|file|mimes:pdf,doc,docx',
    ]);

    // Enregistrement du fichier de rapport d'évaluation
    $path = $request->file('evaluation_report')->store('evaluations', 'public');
    
    $project->evaluation_report = $path;
    $project->status = 'en_attente_evaluation'; // En attente de la validation finale du sponsor
    $project->save();

    return redirect()->back()->with('success', 'Rapport d\'évaluation final transmis au commanditaire (Sponsor) avec succès.');
}
}