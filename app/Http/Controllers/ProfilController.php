<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; 


class ProfilController extends Controller
{
    // public function show()
    // {
    //     $user = Auth::user();
    //     return view('etudiant.profil', compact('user'));
    // }

    public function show()
    {
        $user = auth()->user();
        // Laravel cherche dans resources/views/ + etudiant/profil.blade.php
        return view('etudiant.profil', compact('user')); 
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('photo')) {
            // Optionnel : supprimer l'ancienne photo du disque si elle n'est pas une URL externe
            if ($user->photo && !str_starts_with($user->photo, 'http')) {
                Storage::disk('public')->delete($user->photo);
            }

            // Sauvegarder la nouvelle photo localement
            $path = $request->file('photo')->store('profils', 'public');
            
            // Mettre à jour la base de données avec le chemin relatif
            $user->update(['photo' => $path]);
        }

        return back()->with('success', 'Photo de profil mise à jour avec succès');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Mot de passe changé');
    }
}