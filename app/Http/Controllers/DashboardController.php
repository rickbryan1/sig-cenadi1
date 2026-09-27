<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = Project::with(['sponsor', 'members', 'tasks.user'])->get();
        $members = User::all(); // Ou User::where('role', 'membre')->get() selon votre structure
        $sponsors = User::all(); // Ou User::where('role', 'sponsor')->get()
        $totalProjects = $projects->count();
        $totalBudgetAllocated = $projects->sum('budget_allocated');

        return view('dashboard', compact('user', 'projects', 'members', 'sponsors', 'totalProjects', 'totalBudgetAllocated'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }
}