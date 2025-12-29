<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'photo' => 'required|image|max:2048',
        ]);

        $user = auth()->user();
        $file = $request->file('photo');
        $fileName = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        $storage = app('firebase.storage');
        $bucket = $storage->getBucket();

        $bucket->upload(fopen($file->getRealPath(), 'r'), [
            'name' => 'profils/' . $fileName,
            'predefinedAcl' => 'publicRead'
        ]);

        $user->photo = "https://storage.googleapis.com/" . env('FIREBASE_STORAGE_BUCKET') . "/profils/" . $fileName;
        $user->save();

        return back()->with('success', 'Photo mise à jour');
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