<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|url',
        ]);

        $user->name = $validated['name'];
        if ($request->filled('avatar')) {
            $user->avatar = $validated['avatar'];
        }
        $user->save();

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
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