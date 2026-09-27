<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class SponsorController extends Controller
{
    // Afficher tous les projets assignés au sponsor connecté
    public function index()
    {
        $user = Auth::user();
        // Récupérer la collection de tous les projets associés au sponsor connecté
        $projects = Project::where('sponsor_id', $user->id)->get(); 

        return view('sponsor', compact('user', 'projects'));
    }

    // Le Sponsor valide la planification du projet
    public function validateProject($id)
    {
        $project = Project::findOrFail($id);
        $project->status = 'en_cours';
        $project->save();

        return redirect()->back()->with('success', 'Planification validée ! Le projet est désormais officiellement EN COURS.');
    }

    // Le Sponsor rejette le projet
    public function rejectProject($id)
    {
        $project = Project::findOrFail($id);
        $project->status = 'rejete';
        $project->save();

        return redirect()->back()->with('success', 'Le projet a été rejeté et renvoyé au chef de projet pour modification.');
    }

    // Le Sponsor valide le rapport d'évaluation final et clôture/archive le projet
    public function closeProject($id)
    {
        $project = Project::findOrFail($id);
        $project->status = 'cloture';
        $project->save();

        return redirect()->back()->with('success', 'Rapport validé ! Le projet est désormais officiellement CLÔTURÉ et ARCHIVÉ.');
    }

    // Le Sponsor rejette le rapport final
    public function rejectEvaluation($id)
    {
        $project = Project::findOrFail($id);
        $project->status = 'en_cours'; 
        $project->save();

        return redirect()->back()->with('success', 'Rapport d\'évaluation rejeté. Le projet est renvoyé au chef de projet pour corrections.');
    }
}