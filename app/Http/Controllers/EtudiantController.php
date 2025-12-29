<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Contract\Storage;

class EtudiantController extends Controller
{
    public function index()

    {
        $etudiants = User::where('role', 'etudiant')->paginate(10);
        return view('admin.etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('admin.etudiants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            // Enregistre l'image dans storage/app/public/profils
            $path = $request->file('photo')->store('profils', 'public');
        }

        User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'etudiant',
            'photo' => $path, // On stocke le chemin : profils/image.jpg
        ]);

        return redirect()->route('etudiants.index')->with('success', 'Étudiant ajouté');
    }

    public function edit(User $etudiant)
    {
        return view('admin.etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, User $etudiant)
    {
        $request->validate([
            'name' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:users,email,' . $etudiant->id,
            'phone' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:8048',
        ]);

        // On récupère les données textuelles
        $data = $request->only('name', 'prenom', 'email', 'phone');

        if ($request->hasFile('photo')) {
            // Optionnel : Supprimer l'ancienne photo si elle existe
            // if($etudiant->photo) { Storage::disk('public')->delete($etudiant->photo); }

            // On enregistre la nouvelle et on ajoute le chemin aux données à mettre à jour
            $data['photo'] = $request->file('photo')->store('profils', 'public');
        }

        // On met à jour l'étudiant avec le tableau $data qui contient (ou pas) la photo
        $etudiant->update($data);

        return redirect()->route('etudiants.index')->with('success', 'Étudiant mis à jour');
    }

    public function destroy(User $etudiant)
    {
        $etudiant->delete();
        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé');
    }
}