<?php

use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('etudiants', EtudiantController::class);
});

// Routes étudiant
Route::middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    Route::post('/profil/update-password', [ProfilController::class, 'updatePassword'])->name('profil.update-password');
});

require __DIR__.'/auth.php';
