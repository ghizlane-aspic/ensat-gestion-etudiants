<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'etudiant',
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
            'email' => 'required|email|unique:users,email,' . $etudiant->id,
        ]);

        $etudiant->update($request->only('name', 'email'));
        return redirect()->route('etudiants.index')->with('success', 'Étudiant mis à jour');
    }

    public function destroy(User $etudiant)
    {
        $etudiant->delete();
        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé');
    }
}